<?php

namespace ContactMyReps\Sunlight;

use ContactMyReps\Sunlight\api\openstates as OpenStates;
use ContactMyReps\Sunlight\api\congress as Congress;

class SunlightTest extends \PHPUnit_Framework_TestCase
{

	protected $sunlight;
	protected $states;

	protected function setUp()
	{
		$this->sunlight = new Sunlight('695e61a2595a4f5aa9122ee4225c8247');
    	$this->states = $this->sunlight->openStates();
        $this->congress = $this->sunlight->congress();
    	$this->faker = \Faker\Factory::create();
	}

	public function testRegisterSunlight()
	{
		$this->assertNotNull($this->sunlight);
	}

    public function testRegisterOpenStates()
    {
    	$this->assertNotNull($this->states);
		$this->assertInstanceOf('\\ContactMyReps\\Sunlight\\API\\OpenStates', $this->states);
    }

    public function testOpenStatesGetSyncJson()
    {
    	$this->states->option(['async' => false, 'json' => true]);
    	$data = $this->states->legislators(
            [
                'state' => 'AL',
                'district' => 1
            ],
            [
                'last_name'
            ]
        );
    	$this->assertTrue(is_string($data));
        $this->assertTrue(stripos($data, '"id":') !== false);
        $this->assertTrue(stripos($data, '"first_name":') === false);
    }

    public function testOpenStatesGetSyncArray()
    {
        $this->states->option(['async' => false, 'json' => false]);
        $data = $this->states->legislators(
            [
                'state' => 'AL',
                'district' => 1
            ],
            [
                'last_name'
            ]
        );
        $this->assertTrue(is_array($data));
        $this->assertTrue(is_object($data[0]));
        $this->assertTrue(!isset($data[0]->first_name));
    }

    public function testOpenStatesGetAsyncJson()
    {
        $this->states->option(['async' => true, 'json' => true]);
        $request = $this->states->legislators(['state'=>$this->faker->stateAbbr()])->then(
            function($data){
                $this->assertTrue(is_string($data));
                $this->assertTrue(stripos($data, '"id":') !== false);
    		}
    	);
    	$request->wait();
    }

    public function testCongressGetSyncArray()
    {
        $this->congress->option(['async' => false, 'json' => false]);
        $data = $this->congress->legislators(
            [
                'state' => $this->faker->stateAbbr()
            ],
            [
                'last_name'
            ]
        );
        $this->assertTrue(is_object($data));
        $this->assertTrue(is_array($data->results));
        $this->assertTrue(isset($data->results[0]->last_name));
        $this->assertTrue(!isset($data->results[0]->first_name));
    }

}
