<?php

namespace Enigmatic\CRMBundle\Services;

use Geocoder\Exception\ChainNoResultException;
use Ivory\GoogleMap\Map;
use Ivory\GoogleMap\MapTypeId;
use Ivory\GoogleMap\Overlays\InfoWindow;
use Ivory\GoogleMap\Overlays\Marker;

class MapService
{
    public function generateAction($address, $info_bulle = '', $width = '100%', $height = '100%') {
        $geocoder = new \Geocoder\Geocoder();
        $adapter  = new \Geocoder\HttpAdapter\CurlHttpAdapter();
        $chain    = new \Geocoder\Provider\ChainProvider(array(
            new \Geocoder\Provider\FreeGeoIpProvider($adapter),
            new \Geocoder\Provider\HostIpProvider($adapter),
            new \Geocoder\Provider\GoogleMapsProvider($adapter, 'fr_FR', 'France', true),
            new \Geocoder\Provider\BingMapsProvider($adapter, 'AIzaSyBZ3sNuoMPrXGCNbhnEbGmfzGxOohhEX4E'),
        ));
        $geocoder->registerProvider($chain);

        $address = urldecode($address);
        $info_bulle = urldecode($info_bulle);

        // Récupération des coordonnées du programme
        try {
            $coordonnees = $geocoder->geocode($address);
        }
        catch (ChainNoResultException $e) {
            try {
                $coordonnees = $geocoder->geocode('France');
            }
            catch (ChainNoResultException $e) {
                return false;
            }
        }

        $info_content = '<div style="min-width:150px;text-align:center;">'.$info_bulle.'</div>';

        $info_window = new InfoWindow();
        $info_window->setAutoOpen(true);
        $info_window->setOpen(true);
        $info_window->setContent($info_content);

        $marker = new Marker();
        $marker->setPosition($coordonnees->getLatitude(), $coordonnees->getLongitude(), true);
        $marker->setAnimation('drop');
        $marker->setOption('clickable', true);
        $marker->setOption('flat', true);
        if ($info_bulle)
            $marker->setInfoWindow($info_window);

        // Création de la map
        $map = new Map();
        $map->setPrefixJavascriptVariable('map_');
        $map->setHtmlContainerId('map_canvas');
        $map->setAsync(true);
        $map->setAutoZoom(false);
        $map->setCenter($coordonnees->getLatitude(), $coordonnees->getLongitude(), true);
        $map->setMapOption('zoom', 12);
        $map->setMapOption('mapTypeId', MapTypeId::ROADMAP);
        $map->setMapOption('disableDefaultUI', false);
        $map->setMapOption('disableDoubleClickZoom', false);
        $map->setStylesheetOption('width', $width);
        $map->setStylesheetOption('height', $height);
        $map->setLanguage('fr');
        $map->addMarker($marker);

        return $map;
    }
}
