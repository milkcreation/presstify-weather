<?php

namespace Weather;

use Cmfcmf\OpenWeatherMap;
use Cmfcmf\OpenWeatherMap\Exception as OWMException;
use League\Period\Period;
use tiFy\App\Set;
use Weather\SchedulesModal\SchedulesModal;

class Weather extends Set
{
    /**
     * CONSTRUCTEUR
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();

        $this->appShareContainer('weather.schedules_modal', new SchedulesModal);

        require_once $this->appDirname() . '/vendor/autoload.php';
        require_once $this->appDirname() . '/Helpers.php';
    }

    /**
     * Description de la météo
     *
     * @return array
     */
    public static function get_weather_info()
    {
        /**
         * @see https://openweathermap.org/
         * @see https://github.com/cmfcmf/OpenWeatherMap-PHP-Api
         * @see https://github.com/erikflowers/weather-icons
         */

        //Déclaration de la clé d'API
        $owm = new OpenWeatherMap('64d059b07e5f5f4493c211c784f70a29');

        try {
            $weather = $owm->getWeather('Douai', 'metric', 'fr');
        } catch (OWMException $e) {
            echo 'OpenWeatherMap exception: ' . $e->getMessage() . ' (Code ' . $e->getCode() . ').';
        } catch (\Exception $e) {
            echo 'General exception: ' . $e->getMessage() . ' (Code ' . $e->getCode() . ').';
        }

        //Récupération du texte de la météo
        $weather_text = ($weather->weather->description);


        // Définition de la période
        $timezone = new \DateTimeZone(get_option('timezone_string', 'Europe/Paris'));

        // lever
        $rise = $weather->sun->rise;
        $rise->setTimezone($timezone);

        // Coucher
        $set = $weather->sun->set;
        $set->setTimezone($timezone);

        // Maintenant
        $now = new \DateTime();
        $now->setTimezone($timezone);

        // Jour ou nuit
        $period = new Period($rise, $set);
        $day = !$period->isBefore($now) && !$period->isAfter($now);

        // Récupération icône
        $map_file = '/resources/icons.json';
        $map = json_decode(file_get_contents(self::tFyAppDirname() . $map_file), true);

        if (file_exists(self::tFyAppDirname() ."/resources/svg/wi-day-" . $map[$weather->weather->id]['icon'] . ".svg")) :
            $svg_file = "/resources/svg/wi-day-" . $map[$weather->weather->id]['icon'] . ".svg";
        else :
            $svg_file = "/resources/svg/wi-na.svg";
        endif;

        //Déclaration des variables
        $date = date_i18n('l j F Y', current_time('timestamp', false));

        $weather_icon = file_get_contents(self::tFyAppDirname() . $svg_file);


        return [
            'date'         => $date,
            'weather_text' => $weather_text,
            'weather_icon' => $weather_icon
        ];

    }

    /**
     * Description de la météo
     *
     * @return string
     */
    public static function display()
    {
        $info = self::get_weather_info();

        $date = $info['date'];
        $weather_text = $info['weather_text'];
        $weather_icon = $info['weather_icon'];


        self::tFyAppGetTemplatePart('weather', null, compact('date', 'weather_text', 'weather_icon'));
    }

    public static function sidebar_display()
    {
        $info = self::get_weather_info();

        $date = $info['date'];
        $weather_text = $info['weather_text'];
        $weather_icon = $info['weather_icon'];

        self::tFyAppGetTemplatePart('weather-sidebar', null, compact('date', 'weather_text', 'weather_icon'));
    }

    /**
     * Récupération des dépendances
     *
     * @param string $name Identifant de qualification de la dépendance
     *
     * @return null|Weather
     */
    public static function get($name)
    {
        $name = self::tFyAppLowerName($name, '_');
        $id = "weather.{$name}";

        if (self::tFyAppHasContainer($id)) :
            return self::tFyAppGetContainer($id);
        endif;
    }
}