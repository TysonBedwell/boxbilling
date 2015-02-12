<?php
/**
 * @group Core
 */
class Api_Admin_CurrencyTest extends BBDbApiTestCase
{
    protected $_initialSeedFile = 'currencies.xml';
    
    public function testCurrencies()
    {
        $array = $this->api_admin->currency_get_pairs();
        $this->assertInternalType('array', $array);

        $array = $this->api_admin->currency_get(array('code' => 'USD'));
        $this->assertInternalType('array', $array);
        $this->assertEquals('USD', $array['code']);

        $array = $this->api_admin->currency_get_default();
        $this->assertInternalType('array', $array);

        $data = array(
            'code'  =>    'GBP',
            'title'  =>    'British Pound',
            'format'  =>    '{{price}}£',
        );
        $code = $this->api_admin->currency_create($data);
        $this->assertInternalType('string', $code);

        $bool = $this->api_admin->currency_update($data);
        $this->assertTrue($bool);

        $bool = $this->api_admin->currency_delete($data);
        $this->assertTrue($bool);
        
        $data['code'] = 'EUR';
        $bool = $this->api_admin->currency_set_default($data);
        $this->assertTrue($bool);

        $bool = $this->api_admin->currency_update_rates();
        $this->assertTrue($bool);
    }

    public function testCurerncyGetList()
    {
        $array = $this->api_admin->currency_get_list();
        $this->assertInternalType('array', $array);

        $this->assertArrayHasKey('list', $array);
        $list = $array['list'];
        $this->assertInternalType('array', $list);
        if (count($list)){
            $item = $list[0];
            $this->assertArrayHasKey('code', $item);
            $this->assertArrayHasKey('title', $item);
            $this->assertArrayHasKey('conversion_rate', $item);
            $this->assertArrayHasKey('format', $item);
            $this->assertArrayHasKey('price_format', $item);
            $this->assertArrayHasKey('default', $item);
        }
    }
}