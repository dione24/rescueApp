<?php

namespace App\Services;

use InvalidArgumentException;

class PolygonService
{
    public function isInsideAnyPolygon($point, $polygons)
    {
        foreach ($polygons as $polygon) {
            $vertices = json_decode($polygon->vertices, true);

            if (is_array($vertices) && isset($vertices[0]) && $this->isInsidePolygon($point, $vertices)) {
                return true;
            }
        }

        return false;
    }

    public function isInsidePolygon($point, $polygon)
    {
        if (!is_array($polygon)) {
            throw new InvalidArgumentException('Polygon must be an array of points');
        }

        $x = $point['longitude'];
        $y = $point['latitude'];

        $inside = false;
        for ($i = 0, $j = count($polygon) - 1; $i < count($polygon); $j = $i++) {
            $xi = $polygon[$i][0]; // Longitude
            $yi = $polygon[$i][1]; // Latitude
            $xj = $polygon[$j][0]; // Longitude
            $yj = $polygon[$j][1]; // Latitude

            $intersect = (($yi > $y) != ($yj > $y)) && ($x < ($xj - $xi) * ($y - $yi) / ($yj - $yi) + $xi);
            if ($intersect) {
                $inside = !$inside;
            }
        }

        return $inside;
    }
}
