<?php

require __DIR__ . '/../vendor/autoload.php';

use App\Database;

$pdo = Database::getConnection();

$pdo->exec("SET FOREIGN_KEY_CHECKS = 0");
$pdo->exec("TRUNCATE article_category");
$pdo->exec("TRUNCATE articles");
$pdo->exec("TRUNCATE categories");
$pdo->exec("SET FOREIGN_KEY_CHECKS = 1");

$categories = [
    'tech' => ['title' => 'Technology', 'description' => 'Gadgets, software, and the ideas driving modern technology forward.'],
    'ai' => ['title' => 'AI', 'description' => 'Artificial intelligence: how it learns, creates, and reshapes the way we live and work.'],
    'bci' => ['title' => 'BCI', 'description' => 'Brain-computer interfaces: connecting minds and machines through neural technology.'],
];

$stmt = $pdo->prepare("INSERT INTO categories (title, description) VALUES (:title, :description)");
$stmt->bindParam(':title', $title);
$stmt->bindParam(':description', $description);

$catIds = [];
foreach ($categories as $key => $c) {
    $title = $c['title'];
    $description = $c['description'];
    $stmt->execute();
    $catIds[$key] = (int) $pdo->lastInsertId();
}

$articles = [
    [
        'categories'  => ['ai', 'tech'],
        'title'       => 'How does AI affect how we learn?',
        'description' => 'A cognitive psychologist on how AI tools can either sharpen or dull learning, depending on how they are used.',
        'content'     => 'AI tutoring modes show real promise, but leaning on AI to skip the hard parts of learning risks cognitive atrophy. Struggle, friction and mental effort are what build genuine mastery. The brain behaves like a muscle: it grows through challenging workouts, not by outsourcing the effort. Students who let AI complete assignments may pass the task but lose the learning.',
        'image'       => '/uploads/1-ai-learn.jpg',
        'created_at'  => '2026-07-24 10:00:00',
        'views'       => 412,
    ],
    [
        'categories'  => ['bci', 'tech'],
        'title'       => 'Why scientists are worried about Neuralink',
        'description' => 'Ethical and safety concerns around Elon Musk\'s brain-computer interface company, from transparency to privacy.',
        'content'     => 'Neuralink promises direct links between brains and computers, but researchers flag serious concerns: lack of transparency and clinical-trial registration, privacy and security risks such as identity theft and blackmail, animal-testing controversies, and questions of equitable access and long-term patient care once trials end. The private-equity model may prioritize profit over patient welfare.',
        'image'       => '/uploads/2-neuralink.jpg',
        'created_at'  => '2026-07-22 14:30:00',
        'views'       => 287,
    ],
    [
        'categories'  => ['ai', 'tech'],
        'title'       => 'How to glimpse a pre-AI internet',
        'description' => 'A browser extension called Slop Evader lets you search archived versions of the web from before the AI-content flood.',
        'content'     => 'Generative AI has filled the internet with "slop" — fake images, videos and unreliable articles. Slop Evader, built by environmental engineer Tega Brain, searches pre-November-2022 archives of platforms like Reddit and YouTube, offering a temporary window into what the internet used to be just a few short years ago.',
        'image'       => '/uploads/3-pre-ai-internet.png',
        'created_at'  => '2026-07-19 09:15:00',
        'views'       => 156,
    ],
    [
        'categories'  => ['ai', 'tech', 'bci'],
        'title'       => 'Lab-grown human brain tissue used to control a robot',
        'description' => 'Scientists grew human brain organoids, wired them to chips, and used the "brain-on-chip" system to drive a robot.',
        'content'     => 'A team from Tianjin University and the Southern University of Science and Technology built MetaBOC, described as the first open-source system to combine organoid intelligence with electrode chips and machine-learning algorithms. The lab-grown brain tissue can control a robot to navigate its environment and grasp objects — a step toward hybrid biological-digital computing.',
        'image'       => '/uploads/4-brain-robot.jpg',
        'created_at'  => '2026-07-16 18:45:00',
        'views'       => 534,
    ],
    [
        'categories'  => ['ai', 'tech', 'bci'],
        'title'       => 'MIT is making a device that can "hear" the words you say silently',
        'description' => 'AlterEgo, a prototype headset, reads electrical signals from facial muscles to recognize silently mouthed words.',
        'content'     => 'MIT researchers built AlterEgo, a headset whose electrodes detect the faint electrical signals your facial muscles produce when you mouth words silently. It can recognize those words and run commands with no audible speech. As its creator puts it: "You\'re completely silent, but talking to yourself. It\'s neither thinking nor speaking."',
        'image'       => '/uploads/5-silent-speech.jpg',
        'created_at'  => '2026-07-13 11:20:00',
        'views'       => 203,
    ],
    [
        'categories'  => ['ai', 'tech'],
        'title'       => '"Dune" tried to warn us against AI',
        'description' => 'Frank Herbert\'s Dune banned thinking machines — and its warning is really about who controls the technology.',
        'content'     => 'In Dune, the Butlerian Jihad outlaws artificial intelligence. The real warning, the article argues, is not sentient machines but the concentration of power in the hands of a technocratic few. As Herbert wrote: "Once men turned their thinking over to machines in the hope that this would set them free. But that only permitted other men with machines to enslave them."',
        'image'       => '/uploads/6-dune-ai.png',
        'created_at'  => '2026-07-10 16:00:00',
        'views'       => 178,
    ],
    [
        'categories'  => ['ai', 'tech'],
        'title'       => 'This font uses an optical illusion to hide from AI',
        'description' => 'Ghost Font hides text inside moving dot animations that humans can read but current AI cannot.',
        'content'     => 'Designer Eric Lu created Ghost Font, which conceals text within moving dot animations. Humans perceive the motion as fluid patterns and can read the words, while multimodal AI — which still examines video frame by frame — cannot. The creator admits the advantage may be temporary as AI capabilities evolve.',
        'image'       => '/uploads/7-ghost-font.png',
        'created_at'  => '2026-07-07 08:30:00',
        'views'       => 91,
    ],
];

$artStmt = $pdo->prepare(
    "INSERT INTO articles (title, description, content, image, created_at, views)
     VALUES (?, ?, ?, ?, ?, ?)"
);
$linkStmt = $pdo->prepare(
    "INSERT INTO article_category (article_id, category_id) VALUES (?, ?)"
);

foreach ($articles as $a) {
    $artStmt->execute([
        $a['title'], $a['description'], $a['content'],
        $a['image'], $a['created_at'], $a['views'],
    ]);
    $articleId = (int) $pdo->lastInsertId();

    foreach ($a['categories'] as $catKey) {
        $linkStmt->execute([$articleId, $catIds[$catKey]]);
    }
}

echo "Seeded: " . count($categories) . " категорий, " . count($articles) . " статей\n";


