<?php

namespace Msucevan\Swapi\Console\Commands;


use Exception;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;
use Msucevan\Swapi\Models\Person;
use Msucevan\Swapi\Models\Planet;

class CreateUniverse extends Command
{
    private $baseUrl = 'https://swapi.dev/api/';
    private $peopleEndpoint = 'people/';
    private $planetsEndpoint = 'planets/';
    private $personModelString = 'Person';
    private $planetModelString = 'Planet';

    /**
   * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'create-universe';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'This command will create a new universe with people and their related planets';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $this->info('Download information will start soon');
        
        $this->addFromApi($this->peopleEndpoint, $this->personModelString);

        $this->info('All people have been successfully added to the new universe');

        $this->addFromApi($this->planetsEndpoint, $this->planetModelString);

        $this->info('All planets have been successfully added to the new universe');
    }

    /**
     * Get data from Swapi API
     * 
     * 
     * @return Exception 
     * 
     */

    private function addFromApi($endpoint, $model)
    {
        $retry = 0;

        try {
            do {
                $apinotresponse = false;
                $page = 1;
                $count = 0;
                $pagination = $page > 1 ? '?page=' . $page : "";
                $url = $this->baseUrl . $endpoint . $pagination;
                $json = json_decode(file_get_contents($url));

                if ($json) {
                    
                    do {
                        $json = json_decode(file_get_contents($url));
                        $url = $json->next;

                        for ($i = 0; $i < count($json->results); $i++) {
                            $this->info($json->results[$i]->name);

                            $this->addObject($json->results[$i], $model);

                            $this->info('Adding new ' . $model . ' nr. ' . $count);
                            $count++;
                        }
                    } while ($url != null);
                } else {
                    if ($retry < 5) {
                        $apinotresponse = true;
                        $retry++;
                        sleep(60);
                    }
                }
            } while ($apinotresponse);
        } catch (Exception $e) {
            Log::error($e);
        }
    }


    private function addObject($jsonObject, $model)
    {

        if ($model === $this->personModelString) {

            $person = new Person;

            $person->swapi_id        = filter_var($jsonObject->url, FILTER_SANITIZE_NUMBER_INT);
            $person->name            = $jsonObject->name; 
            $person->height          = $jsonObject->height;
            $person->mass            = $jsonObject->mass;
            $person->hair_color      = $jsonObject->hair_color;
            $person->skin_color      = $jsonObject->skin_color;
            $person->eye_color       = $jsonObject->eye_color;
            $person->birth_year      = $jsonObject->birth_year;
            $person->gender          = $jsonObject->gender;
            $person->homeworld       = $jsonObject->homeworld;
            $person->planet_id       = filter_var($jsonObject->homeworld, FILTER_SANITIZE_NUMBER_INT);
            $person->url             = $jsonObject->url;

            $person->save();

        } else if ($model === $this->planetModelString) {

            $planet = new Planet;

            $planet->swapi_id               = filter_var($jsonObject->url, FILTER_SANITIZE_NUMBER_INT);
            $planet->name                   = $jsonObject->name;
            $planet->rotation_period        = intval($jsonObject->rotation_period);
            $planet->orbital_period         = intval($jsonObject->orbital_period);
            $planet->diameter               = intval($jsonObject->diameter);
            $planet->climate                = $jsonObject->climate;
            $planet->gravity                = $jsonObject->gravity;
            $planet->terrain                = $jsonObject->terrain;
            $planet->surface_water          = intval($jsonObject->surface_water);
            $planet->population             = intval($jsonObject->population);
            $planet->url                    = $jsonObject->url;
            
            $planet->save();
        }
    }
}
