<?php namespace core;

class Utils
{

    public static function getCredential()
    {
        $iniFile = $_SERVER['DOCUMENT_ROOT'] . '/app.ini';
        $data = parse_ini_file($iniFile, true);

        return isset($data['credential']) ? $data['credential'] : [];
    }

    public static function groupOrderby(array $orderbys, array $rules)
    {
        $count = count($orderbys);
        $group_orderbys = [];

        for ($i = 0; $i < $count; $i++) {
            $group_orderbys[] = [
                'column' => $orderbys[$i],
                'rule' => $rules[$i]
            ];
        }

        return $group_orderbys;
    }

    public static function encodeOrderby($orderbys)
    {
        $res = [];

        foreach ($orderbys as $orderby) {
            $res[] = $orderby['rule'] . $orderby['column'];
        }

        return implode(',', $res);
    }

    public static function groupFilters($filters)
    {
        $count = count($filters);
        $group_filters = [];

        if ($count > 0) {
            foreach ($filters as $filter) {

                if (empty($filter[3])) continue;
                $group_filters[] = [
                    'show'      => $filter[0],
                    'column'    => $filter[1],
                    'rule'      => $filter[2],
                    'val'       => $filter[3],
                ];

            }
        }

        return $group_filters;
    }

    public static function encodeDimensionFilters($filters)
    {
        $url = [];

        foreach ($filters as $filter) {
            $operator = "";
            if ($filter['rule'] == "contain") {
                if ($filter['show'] == "show")
                    $operator = '=@';
                else
                    $operator = '!@';
            } else if ($filter['rule'] == "exact") {
                if ($filter['show'] == "show")
                    $operator = '==';
                else
                    $operator = '!=';
            } else if ($filter['rule'] == "regexp") {
                if ($filter['show'] == "show")
                    $operator = '=~';
                else
                    $operator = '!~';
            }

            $url[] = "{$filter['column']}{$operator}{$filter['val']}";
        }

        $uri = implode(";", $url);

        return $uri;
    }

}

