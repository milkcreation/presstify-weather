<?php

namespace tiFy\Plugins\Weather\SchedulesModal;

use tiFy\App\Traits\App as TraitsApp;
use tiFy\Core\Control\Control;

class SchedulesModal 
{
    use TraitsApp;

    /**
     * Bouton d'action d'affichage des informations de contact eveole
     *
     * @return void
     */
    public function schedulesFormModalTrigger()
    {
        Control::call(
            'Modal',
            'trigger',
            [
                'container_class' => 'SchedulesForm-itemClick js-trigger-modal Button Button--3',
                'container_tag'   => 'a',
                'text'            => __('Horaires à l\'arret', 'theme'),
                'target'          => 'schedules_modal',
                'modal'           => [
                    'body'                  => [$this, 'schedulesForm'],
                    'backdrop_close_button' => false,
                    'container_class'       => 'ResponsiveModal'
                ]
            ]
        );
    }

    /**
     * Formulaire de téléchargement des fiches horaires
     *
     * @return void
     */
    public function schedulesForm()
    {
        $wp_query = new \WP_Query;
        $timetables = $wp_query->query(
            [
                'post_type'      => 'line',
                'posts_per_page' => -1,
                'orderby'        => ['menu_order' => 'ASC']
            ]
        );

        // Bypass
        if (!$wp_query->found_posts) :
            return;
        endif;

        $dropdown_selected = $this->appRequestGet('selected', '', 'GET');

        $dropdown_choices[''] = __('Choisissez votre ligne', 'theme');
        foreach ($timetables as $t) :
            $dropdown_choices[get_permalink($t->ID)] = $t->post_title . " " .
                (($_dir = get_post_meta($t->ID, '_direction', true)) ? sprintf('- %s à %s', $_dir['from'], $_dir['to']) : '');
        endforeach;

        self::tFyAppGetTemplatePart('schedules_form', null, compact('dropdown_selected', 'dropdown_choices'));
    }
}
