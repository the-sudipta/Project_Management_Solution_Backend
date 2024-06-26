<?php

global $routes, $system_routes;

require_once __DIR__ . '/../utils/system_functions.php';
require_once __DIR__ . '/../model/patientRepo.php';
require_once __DIR__ . '/../model/progressRepo.php';
require_once __DIR__ . '/../model/care_giverRepo.php';
require_once __DIR__ . '/../model/scheduleRepo.php';
require_once __DIR__ . '/../model/symptom_trackRepo.php';
require_once __DIR__ . '/../model/userRepo.php';


//
//$patient_data = findPatientByID(2);
//
//echo $patient_data['name'] . '<br>';
//
//$test = $routes['login'];
//echo 'test = '.$test;


function getOnlineScheduleCountByThePatientsAddedByTheCareGiver($care_giver_id): int
{
    // Step 1: Fetch all the Patients from patients table by Care Giver ID
    $patients = null;
    $patients = findAllPatientsByCareGiverID($care_giver_id);
    if($patients !== null){
        $onlineScheduleCount = 0;

        // Step 2: Fetch All the Schedules by each patient id and count 'Online' schedules
        foreach ($patients as $patient) {
            $schedules = findAllSchedulesByPatientID($patient['id']);
            if(isset($schedules)){
                foreach ($schedules as $schedule) {
                    if(isset($schedule['type'])){
                        if ($schedule['type'] === 'Online') {
                            $onlineScheduleCount++;
                        }
                    }else{
                        return 0;
                    }
                }
            }else{
                return 0;
            }
        }

        // Step 3: Return the total count
        return $onlineScheduleCount;
    }else{
        return 0;
    }

}

function getOfflineScheduleCountByThePatientsAddedByTheCareGiver($care_giver_id): int
{
    // Step 1: Fetch all the Patients from patients table by Care Giver ID
    $patients = null;
    $patients = findAllPatientsByCareGiverID($care_giver_id);
    if($patients !== null){
        $onlineScheduleCount = 0;

        // Step 2: Fetch All the Schedules by each patient id and count 'Online' schedules
        foreach ($patients as $patient) {
            $schedules = findAllSchedulesByPatientID($patient['id']);
            if(isset($schedules)){
                foreach ($schedules as $schedule) {
                    if(isset($schedule['type'])){
                        if ($schedule['type'] === 'Offline') {
                            $onlineScheduleCount++;
                        }
                    }else{
                        return 0;
                    }
                }
            }else{
                return 0;
            }
        }

        // Step 3: Return the total count
        return $onlineScheduleCount;
    }else{
        return 0;
    }
}

function getTotalPatientCountByCareGiverID($care_giver_id): int
{
    $patients = null;
    // Step 1: Fetch all the Patients from patients table by Care Giver ID
    $patients = findAllPatientsByCareGiverID($care_giver_id);

    if($patients !== null){
        // Step 2: Count the Number of Rows found
        $totalPatientCount = count($patients);

        return $totalPatientCount;
    }else{
        return 0;
    }
}

function getTotal_MALE_PatientCountByCareGiverID($care_giver_id): int
{
    // Step 1: Fetch all the Patients from patients table by Care Giver ID
    $patients = findAllPatientsByCareGiverID($care_giver_id);

    // Initialize the male patient count to 0
    $malePatientCount = 0;

    // Check if $patients is an array and not null
    if (is_array($patients)) {
        // Step 2: Count the Number of Rows if gender is 'Male'
        foreach ($patients as $patient) {
            if ($patient['gender'] === 'Male') {
                $malePatientCount++;
            }
        }
    } else {
        // Log an error message or handle the case where no patients are found
        error_log("No patients found for Care Giver ID: " . $care_giver_id);
    }

    return $malePatientCount;
}

function getTotal_FEMALE_PatientCountByCareGiverID($care_giver_id): int
{
    // Step 1: Fetch all the Patients from patients table by Care Giver ID
    $patients = findAllPatientsByCareGiverID($care_giver_id);
    $femalePatientCount = 0;

    // Check if $patients is an array and not null
    if (is_array($patients)) {
        // Step 2: Count the Number of Rows if gender is 'Female'
        foreach ($patients as $patient) {
            if ($patient['gender'] === 'Female') {
                $femalePatientCount++;
            }
        }
    } else {
        // Log an error message or handle the case where no patients are found
        error_log("No patients found for Care Giver ID: " . $care_giver_id);
    }

    return $femalePatientCount;
}


function getOnlineSchedulePercentageChange($care_giver_id): string
{
    $patients = null;
    // Fetch all the Patients from patients table by Care Giver ID
    $patients = findAllPatientsByCareGiverID($care_giver_id);

    if($patients !== null){
        // Get the current month and year
        $currentMonth = date('m');
        $currentYear = date('Y');

        // Calculate the previous month and year
        $previousMonth = ($currentMonth == 1) ? 12 : $currentMonth - 1;
        $previousYear = ($currentMonth == 1) ? $currentYear - 1 : $currentYear;

        $currentMonthCount = 0;
        $previousMonthCount = 0;

        // Fetch All the Schedules by each patient id and count 'Online' schedules for the current and previous month
        foreach ($patients as $patient) {
            $schedules = null;
            $schedules = findAllSchedulesByPatientID($patient['id']);
            if($schedules !== null){
                foreach ($schedules as $schedule) {
                    if(isset($schedule)){
                        $scheduleDate = new DateTime($schedule['date']);
                        $scheduleYear = $scheduleDate->format('Y');
                        $scheduleMonth = $scheduleDate->format('m');

                        if(isset($schedule['type'])){
                            if ($schedule['type'] === 'Online') {
                                if ($scheduleYear == $currentYear && $scheduleMonth == $currentMonth) {
                                    $currentMonthCount++;
                                } elseif ($scheduleYear == $previousYear && $scheduleMonth == $previousMonth) {
                                    $previousMonthCount++;
                                }
                            }
                        }
                    }
                }
            }
        }

        // Calculate the percentage change
        if ($previousMonthCount == 0) {
            // If there were no schedules in the previous month, the percentage change is 100% if there are schedules in the current month
            $percentageChange = ($currentMonthCount > 0) ? 100.0 : 0.0;
        } else {
            $percentageChange = (($currentMonthCount - $previousMonthCount) / $previousMonthCount) * 100;
        }

        // Determine the sign for the percentage change
        if ($percentageChange > 0) {
            return '+' . number_format($percentageChange, 2) . '%';
        } elseif ($percentageChange < 0) {
            return number_format($percentageChange, 2) . '%';
        } else {
            return '0.00%';
        }
    }else{
        return '0.00%';
    }

}

function getOfflineSchedulePercentageChange($care_giver_id): string
{
    $patients = null;
    // Fetch all the Patients from patients table by Care Giver ID
    $patients = findAllPatientsByCareGiverID($care_giver_id);

    if($patients !== null){

        // Get the current month and year
        $currentMonth = date('m');
        $currentYear = date('Y');

        // Calculate the previous month and year
        $previousMonth = ($currentMonth == 1) ? 12 : $currentMonth - 1;
        $previousYear = ($currentMonth == 1) ? $currentYear - 1 : $currentYear;

        $currentMonthCount = 0;
        $previousMonthCount = 0;

        // Fetch All the Schedules by each patient id and count 'Online' schedules for the current and previous month
        foreach ($patients as $patient) {
            $schedules = findAllSchedulesByPatientID($patient['id']);
            foreach ($schedules as $schedule) {
                $scheduleDate = new DateTime($schedule['date']);
                $scheduleYear = $scheduleDate->format('Y');
                $scheduleMonth = $scheduleDate->format('m');

                if ($schedule['type'] === 'Offline') {
                    if ($scheduleYear == $currentYear && $scheduleMonth == $currentMonth) {
                        $currentMonthCount++;
                    } elseif ($scheduleYear == $previousYear && $scheduleMonth == $previousMonth) {
                        $previousMonthCount++;
                    }
                }
            }
        }

        // Calculate the percentage change
        if ($previousMonthCount == 0) {
            // If there were no schedules in the previous month, the percentage change is 100% if there are schedules in the current month
            $percentageChange = ($currentMonthCount > 0) ? 100.0 : 0.0;
        } else {
            $percentageChange = (($currentMonthCount - $previousMonthCount) / $previousMonthCount) * 100;
        }

        // Determine the sign for the percentage change
        if ($percentageChange > 0) {
            return '+' . number_format($percentageChange, 2) . '%';
        } elseif ($percentageChange < 0) {
            return number_format($percentageChange, 2) . '%';
        } else {
            return '0.00%';
        }
    }else{
        return '0.00%';
    }

}

