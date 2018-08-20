<?php
/**
 * Formulaire de téléchargement des fiches horaires
 *
 * @var string $timetable_error
 * @var int $dropdown_selected
 * @var array $dropdown_choices
 */
?>
<section id="schedules-section" class="Section-schedules">
    <h3 class="Section-schedulesTitle"><?php _e('Horaires à votre arrêt', 'theme'); ?></h3>

    <form action="<?php echo home_url(); ?>" method="post" id="schedules-form"
          class="Section-schedulesForm clearfix" autocomplete="off">
        <div class="SchedulesFormFieldsGroup SchedulesFormFieldsGroup--simple" id="timetable-choice">
            <div class="SchedulesFormFieldsWrapper clearfix">
                <div class="SchedulesFormField SchedulesFormField--simple">
                    <?php
                    tify_field_select_js(
                        [
                            'container_class' => 'Schedules-formDropdownWrapper',
                            'container_id'    => 'timetable-dropdown',
                            'name'            => 'timetable_attachment_id',
                            'options'         => $dropdown_choices,
                            'value'           => $dropdown_selected,
                            'picker_class'    => 'Schedules-formDropdownChoices',
                        ]
                    );
                    ?>
                </div>
            </div>
        </div>
    </form>
    <div class="SectionSchedules-inner">
        <a class="SectionSchedules-link" href="<?php echo get_post_type_archive_link('line'); ?>" title="<?php _e('Trouver un arrêt', 'theme'); ?>"></a>
        <div class="SectionSchedules-icon">
            <?php \tiFy\Lib\Utils::get_svg(get_stylesheet_directory() . '/images/svg/location.svg', true); ?>
        </div>
        <span class="SectionSchedules-text"><?php _e('Trouver un arrêt', 'theme'); ?></span>
    </div>
</section>