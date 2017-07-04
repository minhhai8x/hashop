<?php

namespace AdminBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Ob\HighchartsBundle\Highcharts\Highchart;

class DefaultController extends Controller
{
    public function indexAction()
    {
        $translator         = $this->get('translator');
        $adminGlobalManager = $this->get('utils.admin.global.manager');
        $statisticsData     = $adminGlobalManager->getCurrentYearOrderStatistics();

        // Chart
        $series = array(
            array(
                "name" => $translator->trans('statistics.data.serie.name'),
                "data" => array_values($statisticsData)
            )
        );

        $ob = new Highchart();
        $ob->chart->renderTo('linechart');  // The #id of the div where to render the chart
        $ob->title->text($translator->trans('statistics.title') . ' ' . date('Y'));
        $ob->xAxis->title(array('text'  => $translator->trans('statistics.horizontal.axis.title')));
        $ob->xAxis->categories(array(
            $translator->trans('month.jan.label'),
            $translator->trans('month.feb.label'),
            $translator->trans('month.mar.label'),
            $translator->trans('month.apr.label'),
            $translator->trans('month.may.label'),
            $translator->trans('month.jun.label'),
            $translator->trans('month.jul.label'),
            $translator->trans('month.aug.label'),
            $translator->trans('month.sep.label'),
            $translator->trans('month.oct.label'),
            $translator->trans('month.nov.label'),
            $translator->trans('month.dec.label'),
        ));

        $ob->yAxis->title(array('text'  => $translator->trans('statistics.vertical.axis.title')));
        $ob->series($series);

        return $this->render('AdminBundle:Default:statistics.html.twig', array('chart' => $ob));
    }
}
