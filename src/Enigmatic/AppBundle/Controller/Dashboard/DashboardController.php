<?php

namespace Enigmatic\AppBundle\Controller\Dashboard;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;

class DashboardController extends Controller
{
    const CAMPAIGN_LEAD_COUNT = 5;
    const CAMPAIGN_OPPORTUNITY_COUNT = 5;
    const CAMPAIGN_CLOSE_REVENUE_COUNT = 5;

    /**
     * @Route(
     *      "/enigmatic_app/test/{widget}",
     *      name="enigmatic_app_dashboard_test",
     *      requirements={"widget"="[\w-]+"}
     * )
     * @Template("EnigmaticAppBundle:Dashboard:test.html.twig")
     */
    public function testAction($widget)
    {
        $items = $this->getDoctrine()
            ->getRepository('OroCRMCampaignBundle:Campaign')
            ->getCampaignsLeads($this->get('oro_security.acl_helper'), self::CAMPAIGN_LEAD_COUNT);

        $widgetAttr = $this->get('oro_dashboard.widget_configs')->getWidgetAttributesForTwig($widget);
        $widgetAttr['chartView'] = $this->get('oro_chart.view_builder')
            ->setArrayData($items)
            ->setOptions(
                array(
                    'name' => 'bar_chart',
                    'data_schema' => array(
                        'label' => array('field_name' => 'label'),
                        'value' => array('field_name' => 'number')
                    ),
                    'settings' => array('xNoTicks' => self::CAMPAIGN_LEAD_COUNT),
                )
            )
            ->getView();

        return $widgetAttr;
    }
}
