<?php

namespace App;

use DateTime;
use DateTimeZone;

class Helper
{
    function getWeatherPrognosisTimes($etd)
    {
        // Convert epoch timestamp to DateTime object
        $date = new DateTime('@' . $etd, new DateTimeZone('UTC'));

        // Get the hour of the timestamp
        $hour = (int)$date->format('H');

        // Calculate the next 3-hour interval after the given hour
        $nextHour = ceil($hour / 3) * 3;

        // Store the first 5 weather prognosis times in an array
        $weatherPrognosisTimes = [];

        for ($i = 0; $i < 5; $i++) {
            // Clone the DateTime object to avoid modifying the original
            $prognosisTime = clone $date;

            // Set the hour to the next 3-hour interval and add the calculated hours
            if ($nextHour == 24) {
                $formattedTime = $prognosisTime->format('d') . '0024';
            } else {
                $prognosisTime->setTime($nextHour % 24, 0);
                $formattedTime = $prognosisTime->format('d') . '00' . str_pad($prognosisTime->format('H'), 2, '0', STR_PAD_LEFT);
            }

            // Add the formatted time to the array
            $weatherPrognosisTimes[] = $formattedTime;

            // Increment by 3 hours for the next interval
            $nextHour += 3;

            // Move to the next day if the hour exceeds 24
            if ($nextHour > 24) {
                $date->modify('+1 day');
                $nextHour = $nextHour % 24;
            }
        }

        return implode(' ', $weatherPrognosisTimes) . 'UKM';
    }

    function formatLatLon($lat, $lon) {
        // Determine if the latitude is north or south
        $direction = ($lat >= 0) ? 'N' : 'S';

        // Ensure latitude is positive for calculation (absolute value)
        $absolute_latitude = abs($lat);

        // Split the absolute latitude into degrees and minutes
        $degrees = floor($absolute_latitude); // Get the whole number part (degrees)
        $decimal_part = $absolute_latitude - $degrees; // Get the decimal part
        $minutes = $decimal_part * 60; // Convert decimal part to minutes

        // Format the minutes to one decimal place
        $formatted_minutes = number_format($minutes, 1);

        // Create the formatted latitude string
        $formatted_latitude = $direction . str_pad($degrees, 2, '0', STR_PAD_LEFT) . str_pad($formatted_minutes, 4, '0', STR_PAD_LEFT);

        // Determine if the longitude is east or west
        $direction = ($lon >= 0) ? 'E' : 'W';

        // Ensure longitude is positive for calculation (absolute value)
        $absolute_longitude = abs($lon);

        // Split the absolute longitude into degrees and minutes
        $degrees = floor($absolute_longitude); // Get the whole number part (degrees)
        $decimal_part = $absolute_longitude - $degrees; // Get the decimal part
        $minutes = $decimal_part * 60; // Convert decimal part to minutes

        // Format the minutes to one decimal place
        $formatted_minutes = number_format($minutes, 1);

        // Create the formatted longitude string
        $formatted_longitude = $direction . str_pad($degrees, 3, '0', STR_PAD_LEFT) . str_pad($formatted_minutes, 4, '0', STR_PAD_LEFT);

        return $formatted_latitude.$formatted_longitude;
    }

    function formatLatLonEtops($lat, $lon) {
        // Determine if the latitude is north or south
        $direction = ($lat >= 0) ? 'N' : 'S';

        // Ensure latitude is positive for calculation (absolute value)
        $absolute_latitude = abs($lat);

        // Split the absolute latitude into degrees and minutes
        $degrees = floor($absolute_latitude); // Get the whole number part (degrees)
        $decimal_part = $absolute_latitude - $degrees; // Get the decimal part
        $minutes = $decimal_part * 60; // Convert decimal part to minutes

        // Format the minutes to one decimal place
        $formatted_minutes = number_format($minutes, 1);

        // Create the formatted latitude string
        $formatted_latitude = $direction . str_pad($degrees, 2, '0', STR_PAD_LEFT) . str_pad($formatted_minutes, 4, '0', STR_PAD_LEFT);

        // Determine if the longitude is east or west
        $direction = ($lon >= 0) ? 'E' : 'W';

        // Ensure longitude is positive for calculation (absolute value)
        $absolute_longitude = abs($lon);

        // Split the absolute longitude into degrees and minutes
        $degrees = floor($absolute_longitude); // Get the whole number part (degrees)
        $decimal_part = $absolute_longitude - $degrees; // Get the decimal part
        $minutes = $decimal_part * 60; // Convert decimal part to minutes

        // Format the minutes to one decimal place
        $formatted_minutes = number_format($minutes, 1);

        // Create the formatted longitude string
        $formatted_longitude = $direction . str_pad($degrees, 3, '0', STR_PAD_LEFT) . str_pad($formatted_minutes, 4, '0', STR_PAD_LEFT);

        return $formatted_latitude.' '.$formatted_longitude;
    }

    function reformatCoordinate($coordinate) {
        // Regular expression to match the coordinate format
        $pattern = '/^(\d{2})(\d{2}[NS])(\d{3})(\d{2}[EW])$/';

        // Check if the string matches the coordinate pattern
        if (preg_match($pattern, $coordinate, $matches)) {
            // Extract the degrees and directions
            $latitude = $matches[1] . $matches[2][2];
            $longitude = $matches[3] . $matches[4][2];
            // Return the reformatted coordinate
            return $latitude . $longitude;
        }

        // If the string does not match the pattern, return it as is
        return $coordinate;
    }

    function formatClimbSpeedProfile($profile) {
        // Split the string by '/'
        $parts = explode('/', $profile);

        // Check if the last part has exactly 2 characters
        if (strlen(end($parts)) == 2) {
            // Prepend 'M' to the last part
            $parts[count($parts) - 1] = 'M' . end($parts);
        }

        // Join the parts back together with '/'
        return implode('/', $parts);
    }

    function formatDescendSpeedProfile($profile)
    {
        $parts = explode('/', $profile);
        if (strlen($parts[0]) == 2) {
            // Prepend 'M' to the first part
            $parts[0] = 'M' . $parts[0];
        }
        return implode('/', $parts);
    }

    function formatPerfPerfFactor($perfFactor) {
        // Calculate the fuel factor percentage
        $percentageChange = ($perfFactor - 1) * 100;
        // Format the percentage with one decimal place
        $formattedPercentage = number_format($percentageChange, 1);
        // Add the sign in front
        if ($percentageChange > 0) {
            $formattedPercentage = '+' . $formattedPercentage;
        } elseif ($percentageChange < 0) {
            $formattedPercentage = '-' . $formattedPercentage;
        } else {
            $formattedPercentage = '0.0';
        }
        return $formattedPercentage;
    }

    function formatAirportElevation($value) {
        $result = str_pad(abs($value),4,'0',STR_PAD_LEFT);
        if ($value < 0) {
            $result = '-' . $result;
        }
        return $result;
    }

    function formatAvgWindComp($value) {
        if ($value < 0) {
            return 'M' . sprintf('%03d', abs($value)); // Negative case
        }
        return 'P' . sprintf('%03d', $value); // Positive case
    }

    function formatEtopsAvgWindComp($value) {
        if ($value < 0) {
            return 'M' . sprintf('%02d', abs($value)); // Negative case
        }
        return 'P' . sprintf('%02d', $value); // Positive case
    }

    function formatOat($value) {
        if ($value < 0) {
            return 'M' . str_pad(abs($value),2,'0',STR_PAD_LEFT);
        }
        return 'P' . str_pad(abs($value),2,'0',STR_PAD_LEFT);
    }

    function getIsa($fix) {
        if ($fix->stage == 'CLB') {
            $isa = 'CLB/CLB';
        } else if ($fix->stage == 'DSC') {
            $isa = 'DSC/DSC';
        } else {
            if ($fix->oat_isa_dev >= 0) {
                $isa = 'P'.str_pad($fix->oat_isa_dev,2,'0',STR_PAD_LEFT).'/'.floor((int)$fix->tropopause_feet/1000);
            } else {
                $isa = 'M'.str_pad($fix->oat_isa_dev,2,'0',STR_PAD_LEFT).'/'.floor((int)$fix->tropopause_feet/1000);
            }
        }

        return $isa;
    }

    function getFormattedFir($section18) {
        preg_match('/\bEET\/([A-Z]+\d+\s*)+\b/', $section18, $matches);

        // Initialize formatted string
        $formattedFirs = '';

        if (!empty($matches)) {
            // Extract the EET section
            $eetSection = $matches[0];

            // Extract individual EET codes
            preg_match_all('/([A-Z]{4})(\d+)/', $eetSection, $eetCodes);

            if (!empty($eetCodes[0])) {
                // Count of EET codes
                $count = count($eetCodes[0]);

                // Number of columns per row
                $columnsPerRow = 5;

                // Number of rows needed
                $rowCount = ceil($count / $columnsPerRow);

                // Iterate for each row
                for ($i = 0; $i < $rowCount; $i++) {
                    $formattedFirs .= "FIRS  ";

                    // Iterate for each column
                    for ($j = 0; $j < $columnsPerRow; $j++) {
                        $index = $i * $columnsPerRow + $j;

                        if ($index < $count) {
                            // Format each EET code as "XXXX/NNNN"
                            $formattedFirs .= substr($eetCodes[1][$index], 0, 4) . '/' . $eetCodes[2][$index] . '  ';
                        }
                    }

                    $formattedFirs = rtrim($formattedFirs) . "\n"; // Remove trailing space and add newline
                }
            }
        }

        return $formattedFirs;
    }

    function getMaxAlt($navlog) {
        $maxAlt = 0;
        foreach ($navlog->fix as $fix) {
            if ((int)$fix->altitude_feet > $maxAlt) {
                $maxAlt = (int)$fix->altitude_feet;
            }
        }
        return $maxAlt;
    }

    function getFuelBucketFuelValue($fuelExtraXml, $label) {
        $fuelValue = 0;
        foreach ($fuelExtraXml->bucket as $bucket) {
            if ((string)$bucket->label == $label) {
                $fuelValue = (string)$bucket->fuel;
                break;
            }
        }
        return $fuelValue;
    }

    function getFuelBucketFuelTime($fuelExtraXml, $label) {
        $fuelTime = 0;
        foreach ($fuelExtraXml->bucket as $bucket) {
            if ((string)$bucket->label == $label) {
                $fuelTime = (string)$bucket->time;
                break;
            }
        }
        return $fuelTime;
    }

    function interpolateEtpDistance($etopsPoint, $navlog) {
        $elapsedTime = (int)$etopsPoint->elapsed_time;

        $i = 0;
        $totalDistance = 0;
        foreach ($navlog->fix as $fix) {
            $totalDistance += (int)$fix->distance;
            if ((int)$fix->time_total > $elapsedTime) {
                $previousFix = $navlog->fix[$i - 1];
                $distance = $totalDistance - $fix->distance +
                    $this->greatCircleDistance((double)$previousFix->pos_lat, (double)$previousFix->pos_long,
                        (double)$etopsPoint->pos_lat_fix, (double)$etopsPoint->pos_long_fix);
                return str_pad(round($distance), 4, '0', STR_PAD_LEFT);
            }
            $i++;
        }

        return '0000';
    }

    function interpolateEtpAnalysisDistance($etopsPoint, $navlog) {
        $elapsedTime = (int)$etopsPoint->elapsed_time;

        $i = 0;
        $totalDistance = 0;
        foreach ($navlog->fix as $fix) {
            $totalDistance += (int)$fix->distance;
            if ((int)$fix->time_total > $elapsedTime) {
                $previousFix = $navlog->fix[$i - 1];
                $distance = $totalDistance - $fix->distance +
                    $this->greatCircleDistance((double)$previousFix->pos_lat, (double)$previousFix->pos_long,
                        (double)$etopsPoint->pos_lat, (double)$etopsPoint->pos_long);
                return str_pad(round($distance), 4, '0', STR_PAD_LEFT);
            }
            $i++;
        }

        return '0000';
    }

    function greatCircleDistance($latitudeFrom, $longitudeFrom, $latitudeTo, $longitudeTo, $earthRadius = 3440.065)
    {
        // Convert from degrees to radians
        $latFrom = deg2rad($latitudeFrom);
        $lonFrom = deg2rad($longitudeFrom);
        $latTo = deg2rad($latitudeTo);
        $lonTo = deg2rad($longitudeTo);

        $latDelta = $latTo - $latFrom;
        $lonDelta = $lonTo - $lonFrom;

        $angle = 2 * asin(sqrt(pow(sin($latDelta / 2), 2) +
                cos($latFrom) * cos($latTo) * pow(sin($lonDelta / 2), 2)));
        return $angle * $earthRadius;
    }
}
