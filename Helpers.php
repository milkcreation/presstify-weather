<?php

use Weather\Weather;
use Weather\SchedulesModal\SchedulesModal;

/**
 * Affichage du bouton d'ouverture de la modal
 *
 * @return string
 */
function schedules_modal_trigger()
{
    /**
     * @var \Weather\SchedulesModal\SchedulesModal $SchedulesModal
     */
    $SchedulesModal = Weather::get('schedules_modal');

    return $SchedulesModal->schedulesFormModalTrigger();
}

/**
 * Affichage de la météo dans le bandeau blanc (contexte responsive)
 *
 * @return string
 */
function set_weather_display()
{
    Weather::display();
}

/**
 * Affichage de la météo dans la sidebar (contexte bureau)
 *
 * @return string
 */
function set_weather_sidebar_display()
{
    Weather::sidebar_display();
}