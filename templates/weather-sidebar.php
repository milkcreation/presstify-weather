<?php
/**
 * @var string $date Date acctuelle
 * @var string $weather_text Texte descriptif de la météo
 * @var string $weather_icon Icône representatif de la météo
 */
?>

<section class="Sidebar-weather">
    <div class="Sidebar-weatherInfo Sidebar-weatherAligner">
        <div class="Sidebar-weatherContent Sidebar-weatherContent--date">
            <span class="Sidebar-weatherContentText Sidebar-weatherContentText--bold">
                <?php _e('Bonjour,', 'theme'); ?>
            </span>
            <span class="Sidebar-weatherContentText">
                <?php _e('nous sommes', 'theme'); ?>
            </span>
            <span class="Sidebar-weatherContentDate Sidebar-weatherContentText--bold Sidebar-weatherContentText--blue">
                <?php echo $date; ?>
            </span>
        </div>
        <div class="Sidebar-weatherContent Sidebar-weatherContent--location">
            <span class="Sidebar-weatherContentText">
                <?php _e('Descriptif météo: ', 'theme'); ?>
            </span>
            <span class="Sidebar-weatherContentDate Sidebar-weatherContentText--bold Sidebar-weatherContentText--blue">
                <?php echo $weather_text; ?>
            </span>
            <span class="Sidebar-weatherContentText">
                <?php _e('à Douai', 'theme'); ?>
            </span>
        </div>
    </div>
    <div class="Sidebar-weatherIcon Sidebar-weatherAligner">
        <?php echo $weather_icon; ?>
    </div>
</section>