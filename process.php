<?php
session_start();

// Allow only POST
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    die("Invalid request");
}

// =======================
// GET FORM DATA
// =======================
$name       = $_POST['name'] ?? '';
$email      = $_POST['email'] ?? '';
$mobile     = $_POST['mobile'] ?? '';
$education  = $_POST['education'] ?? '';
$college    = $_POST['college'] ?? '';
$year       = $_POST['year'] ?? '';
$percentage = $_POST['percentage'] ?? '';
$skills     = $_POST['skills'] ?? [];
$interest   = $_POST['interest'] ?? '';
$city       = $_POST['city'] ?? '';
$state      = $_POST['state'] ?? '';
$relocation = $_POST['relocation'] ?? '';
$duration   = $_POST['duration'] ?? '';
$stipend    = $_POST['stipend'] ?? '';
$about      = $_POST['about'] ?? '';

// =======================
// VALIDATION
// =======================
if (!$name || !$education || !$interest || !$city || !$state || empty($skills)) {
    die("Please fill all required fields");
}

// =======================
// STORE DATA IN JSON
// =======================
$file = __DIR__ . "/data.json";

// Read existing
$data = [];
if (file_exists($file)) {
    $data = json_decode(file_get_contents($file), true) ?? [];
}

// New user
$user = [
    "name" => $name,
    "email" => $email,
    "mobile" => $mobile,
    "education" => $education,
    "college" => $college,
    "year" => $year,
    "percentage" => $percentage,
    "skills" => $skills,
    "interest" => $interest,
    "city" => $city,
    "state" => $state,
    "relocation" => $relocation,
    "duration" => $duration,
    "stipend" => $stipend,
    "about" => $about,
    "time" => date("Y-m-d H:i:s")
];

// Save
$data[] = $user;
file_put_contents($file, json_encode($data, JSON_PRETTY_PRINT));

// =======================
// LOAD INTERNSHIPS
// =======================
$internships = json_decode(file_get_contents("internships.json"), true) ?? [];

// =======================
// SMART AI MATCHING
$results = [];

foreach ($internships as $job) {

    $score = 0;
    $matched = [];

    // 1. Skill Matching (High weight)
    foreach ($skills as $s) {
        if (in_array($s, $job['skills'])) {
            $score += 3; // increased weight
            $matched[] = $s;
        }
    }

    // 2. Interest Matching
    if (stripos($job['sector'], $interest) !== false) {
        $score += 3;
    }

    // 3. Location Matching
    if (stripos($job['location'], $city) !== false) {
        $score += 2;
    }

    if (stripos($job['state'], $state) !== false) {
        $score += 1;
    }

    // 4. Bonus for multiple skills
    if (count($matched) >= 2) {
        $score += 2;
    }

    // 5. Penalty if no skill match
    if (empty($matched)) {
        $score -= 1;
    }

    $job['score'] = max(0, $score);

    // SMART EXPLANATION
    if (!empty($matched)) {
        $job['why'] = "Strong match! Your skills (" . implode(", ", $matched) . ") align with this role.";
    } elseif ($score > 3) {
        $job['why'] = "Good match based on your interest and location.";
    } else {
        $job['why'] = "Basic match. Consider improving relevant skills.";
    }

    $results[] = $job;
}
// Sort
usort($results, fn($a,$b) => $b['score'] <=> $a['score']);

// Top 5
$top = array_slice($results, 0, 5);

// =======================
// STORE IN SESSION
// =======================
$_SESSION['user'] = $user;
$_SESSION['results'] = $top;

// =======================
// REDIRECT
// =======================
header("Location: result.php");
exit();
?>