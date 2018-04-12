<?php

use tiFy\Plugins\Weather\Weather;

/**
 * Affichage du bouton d'ouverture de la modal
 *
 * @return string
 */
function tify_weather_schedules_modal_trigger()
{
    /** @var \Weather\SchedulesModal\SchedulesModal $SchedulesModal */
    $SchedulesModal = Weather::get('schedules_modal');

    return $SchedulesModal->schedulesFormModalTrigger();
}

/**
 * Affichage de la météo dans le bandeau blanc (contexte responsive)
 *
 * @return void
 */
function tify_weather_display()
{
    Weather::display();
}

/**
 * Affichage de la météo dans la sidebar (contexte bureau)
 *
 * @return void
 */
function tify_weather_sidebar_display()
{
    Weather::sidebar_display();
}