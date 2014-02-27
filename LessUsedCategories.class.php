<?php

/**
 * LessUsedCategories extension
 *
 * This program is free software; you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation; either version 2 of the License, or
 * (at your option) any later version.
 *
 * @author Vitaliy Filippov [vitalif at mail.ru]
 * @copyright Copyright (C) 2014+ Vitaliy Filippov
 * @license http://www.gnu.org/copyleft/gpl.html GNU General Public License 2.0 or later
 */

class SpecialLessUsedCategories extends QueryPage
{
    function __construct($name = 'LessUsedCategories')
    {
        parent::__construct($name);
    }

    function isExpensive()
    {
        return true;
    }

    function isSyndicated()
    {
        return false;
    }

    function getQueryInfo()
    {
        $query = array(
            'tables' => array('category'),
            'fields' => array(
                'namespace' => NS_CATEGORY,
                'title' => 'cat_title',
                'value' => 'cat_pages+cat_subcats+cat_files',
            ),
            'conds' => array('cat_pages+cat_subcats+cat_files > 0'),
        );
        // <IntraACL>
        wfRunHooks('FilterPageQuery', array(&$query, 'page', array('page_title=cat_title'), NS_CATEGORY));
        // </IntraACL>
        return $query;
    }

    function sortDescending()
    {
        return false;
    }

    function preprocessResults($db, $res)
    {
        if (!$this->isCached() || !$res->numRows())
        {
            return;
        }
        $batch = new LinkBatch();
        foreach ($res as $row)
        {
            $batch->add($row->namespace, $row->title);
        }
        $batch->execute();

        $res->seek(0);
    }

    function formatResult($skin, $result)
    {
        $title = Title::makeTitleSafe($result->namespace, $result->title);
        if (!$title)
        {
            return Html::element('span', array('class' => 'mw-invalidtitle'),
                Linker::getInvalidTitleDescription($this->getContext(), $result->namespace, $result->title));
        }

        if ($this->isCached())
        {
            $link = Linker::link($title);
        }
        else
        {
            $link = Linker::linkKnown($title);
        }

        $count = $this->msg('nmembers')->numParams($result->value)->escaped();

        return $this->getLanguage()->specialList($link, $count);
    }

    protected function getGroupName()
    {
        return 'maintenance';
    }
}
