<?php
/**
 * @var string $date Date acctuelle
 * @var string $weather_text Texte descriptif de la météo
 * @var string $weather_icon Icône representatif de la météo
 */
?>
<section class="weather-section">
    <div class="weather-sectionInner">
        <div class="weather-sectionInfoWrapper">
            <div class="weather-sectionInfo">
                <div class="weather-sectionContent weather-sectionContent--date">
                    <span class="weather-sectionContentText weather-sectionContentText--bold">
                        <?php _e('Bonjour,', 'theme'); ?>
                    </span>
                    <span class="weather-sectionContentText">
                        <?php _e('nous sommes', 'theme'); ?>
                    </span>
                    <span class="weather-sectionContentDate weather-sectionContentText--bold weather-sectionContentText--blue">
                        <?php echo $date; ?>
                    </span>
                </div>
                <div class="weather-sectionContent weather-sectionContent--location">
                    <span class="weather-sectionContentText">
                        <?php _e('Descriptif météo: ', 'theme'); ?>
                    </span>
                    <span class="weather-sectionContentDate weather-sectionContentText--bold weather-sectionContentText--blue">
                        <?php echo $weather_text; ?>
                    </span>
                    <span class="weather-sectionContentText">
                        <?php _e('à Douai', 'theme'); ?>
                    </span>
                </div>
            </div>
            <div class="weather-icon">
                <?php echo $weather_icon; ?>
            </div>
        </div>
        <div class="SchedulesModal-inner">
            <?php schedules_modal_trigger(); ?>
        </div>
    </div>
</section>
