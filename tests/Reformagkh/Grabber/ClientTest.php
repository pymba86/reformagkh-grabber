<?php

namespace Reformagkh\Grabber;

use PHPUnit\Framework\TestCase;
use Reformagkh\Grabber\Types\Report\ReportingPeriodStateEnum;

class ClientTest extends TestCase
{
    /**
     * @var Client
     */
    protected $client;

    protected function setUp(): void
    {
        $builder = new ClientBuilder(
            'viadmhmao',
            '02dc030');

        $this->client = $builder->build();
    }

    public function testLoginClient()
    {
        $this->client->login('viadmhmao', '02dc030');
        $this->assertNotEmpty($this->client->getToken());
    }

    /**
     * @throws \SoapFault
     */
    public function testGetActualPeriodClient()
    {
        // Получить период отчетный последний
        $result = $this->client->getActualReportPeriod();

        $this->assertTrue($result->state->is(ReportingPeriodStateEnum::CURRENT));
        $this->assertEquals(1, $result->state->getValue());
        $this->assertNotEmpty($result->id);
        $this->assertNotEmpty($result);
    }

    /**
     * @throws \SoapFault
     */
    public function testGetCompanyProfilePage()
    {
        // Получить список организаций с пагинацией
        $result = $this->client->getCompanyProfilePage(
            'd66e5325-3a25-4d29-ba86-4ca351d9704b',
            1,
            465
        );
        $this->assertNotEmpty($result);
    }

    public function testGetCompanyProfileList()
    {
        // Получить список организаций с пагинацией
        $result = $this->client->getCompanyProfileList(
            'd66e5325-3a25-4d29-ba86-4ca351d9704b',
            465
        );

        $maxCount = 100;
        $currentCount = 0;

        foreach ($result as $item) {
            $currentCount++;
            if ($currentCount > $maxCount) {
                break;
            }
        }
        $this->assertNotEmpty($result);
    }

    public function testGetHouseProfileList()
    {
        // Получить список организаций с пагинацией
        $result = $this->client->getHouseProfileList(
            'd66e5325-3a25-4d29-ba86-4ca351d9704b',
            465
        );

        $maxCount = 100;
        $currentCount = 0;

        foreach ($result as $item) {
            $currentCount++;
            echo $item->house_profile_data->house_type . "\n";
            if ($currentCount > $maxCount) {
                break;
            }
        }

        $this->assertNotEmpty($result);
    }

}