<?php

/**
 * @name Weather
 * @desc Extension PresstiFy de gestion de widget météo.
 * @author Louis Dherent <louis@tigreblanc.fr>
 * @package presstify/plugins
 * @namespace \tiFy\Plugins\Weather
 * @version 1.0.0
 */

namespace tiFy\Plugins\Weather;

use Cmfcmf\OpenWeatherMap;
use Cmfcmf\OpenWeatherMap\Exception as OWMException;
use League\Period\Period;
use tiFy\App\Plugin;
use tiFy\Plugins\Weather\SchedulesModal\SchedulesModal;

/**
 * Class Weather
 * @package tiFy\Plugins\Weather
 *
 * @see https://openweathermap.org/
 * @see https://github.com/cmfcmf/OpenWeatherMap-PHP-Api
 * @see https://github.com/erikflowers/weather-icons
 */
class Weather extends Plugin
{
    /**
     * CONSTRUCTEUR.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();

        $this->appShareContainer('weather.schedules_modal', new SchedulesModal);
    }

    /**
     * Description de la météo.
     *
     * @return array
     */
    public static function get_weather_info()
    {
        //Déclaration de la clé d'API
        $owm = new OpenWeatherMap(self::tFyAppConfig('api_key', ''));

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
     * Description de la météo.
     *
     * @return void
     */
    public static function display()
    {
        $info = self::get_weather_info();

        $date = $info['date'];
        $weather_text = $info['weather_text'];
        $weather_icon = $info['weather_icon'];


        self::tFyAppGetTemplatePart('weather', null, compact('date', 'weather_text', 'weather_icon'));
    }

    /**
     * Affichage du module dans la sidebar.
     *
     * @return void
     */
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
     * @return null|object|Weather
     */
    public static function get($name)
    {
        $name = self::tFyAppLowerName($name, '_');
        $id = "weather.{$name}";

        if (self::tFyAppHasContainer($id)) :
            return self::tFyAppGetContainer($id);
        endif;

        return null;
    }
}
