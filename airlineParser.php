<?php
/**
 * Created by PhpStorm.
 * User: sponidelnik
 * Date: 19.07.2018
 * Time: 22:51
 */

final class airlineParser
{
    private $data;
    private $curl;
    private $output;

    public function __construct(parserCurl $curl)
    {
        $this->curl = $curl;
    }

    public function getData()
    {
        return $this->data;
    }

    public function saveJson($fileName)
    {
        file_put_contents(__DIR__ . 'airlineParser.php/' . $fileName . '.json', json_encode($this->data));
    }

    public function parse(outputInterface $output)
    {
        $this->output = $output;

        $this->data = [];
        $chr2 = 47;
        while ($chr2 < 90) {
            $chr2++;
            if ($chr2 < 56 || $chr2 > 64) {
                $chr1 = 47;
                while ($chr1 < 90) {
                    $chr1++;
                    if ($chr1 < 56 || $chr1 > 64) {
                        $iataCode = chr($chr2) . chr($chr1);
                        $airlineInfo = $this->getByIata($iataCode);
                        $this->output->write($iataCode);
                        $this->output->tab();
                        if ($airlineInfo) {
                            $this->data[] = $airlineInfo;
                            $this->output->success('ok');
                            $this->output->line();
                        } else {
                            $this->output->info('not found');
                            $this->output->line();
                        }
                    }
                }
            }
        }

        $this->curl->close();
    }

    private function getByIata($iata)
    {
        $this->curl->setIata($iata);
        $response = $this->curl->exec();
        if ($this->curl->error()) {
            if ($this->output) {
                $this->output->fail($this->curl->error());
            }
            return null;
        }
        return $this->parseResponse($response);
    }

    private function parseResponse($response)
    {
        preg_match_all('/<tr><td(.{0,50})>(.{2,20})<\/td><td>(.{0,100})<\/td><\/tr>/U', $response, $matches, PREG_SET_ORDER);
        $data = [];
        foreach ($matches as $match) {
            if (!empty($matches) && is_array($matches) && isset($match[2]) && isset($match[3])) {
                $columnName = html_entity_decode($match[2]);
                $columnName = str_replace(' ', '_', $columnName);
                $columnName = str_replace(':', '', $columnName);
                $value = html_entity_decode($match[3]);
                $data[$columnName] = $value;
            }
        }
        return (empty($data) ? null : $data);
    }
}