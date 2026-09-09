<?php

require_once('config/config.php');

$user_id = "root";
$user_email = "root";

$buttons = [
    'Login',
    'Logout',
    'Create Record',
    'Update Record',
    'Delete Record',
    'View Record',
    'Upload File',
    'Download',
    'Search',
    'Generate Report'
];

$activityMessage = null;
$activityStatus = null;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $action = $_POST['action'] ?? 'test_activity';

    $status = random_int(0, 1) === 1
        ? 'success'
        : 'failed';

    $success = logActivity(
        $pdo,
        $user_id,
        $user_email,
        $action,
        $status
    );

    if ($success) {
        $activityMessage = $action;
        $activityStatus = $status;
    } else {
        $activityMessage = 'Failed to insert activity log';
        $activityStatus = 'failed';
    }
}

?>

<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="UTF-8">

    <meta
        name="viewport"
        content="width=device-width, initial-scale=1.0"
    >

    <title>IT34A</title>

    <!-- Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com"></script>

</head>


<body class="min-h-screen bg-white text-slate-900">


    <!-- Header -->

    <header class="border-b border-slate-200">

        <div class="mx-auto flex max-w-6xl items-center justify-between px-6 py-5">

            <div>

                <h1 class="text-lg font-semibold tracking-tight">
                    IT34A
                </h1>

                <p class="text-xs text-slate-500">
                    Activity Management System
                </p>

            </div>


            <div class="flex items-center gap-2 text-xs text-slate-500">

                <span class="h-2 w-2 rounded-full bg-emerald-500"></span>

                System Online

            </div>

        </div>

    </header>


    <!-- Main -->

    <main class="mx-auto max-w-6xl px-6 py-12">


        <!-- Introduction -->

        <section class="mb-10">

            <h2 class="text-3xl font-semibold tracking-tight">
                Dashboard
            </h2>

            <p class="mt-2 text-sm text-slate-500">
                Manage and test system activities.
            </p>

        </section>


        <!-- Actions -->

        <section>

            <div class="mb-4">

                <h3 class="text-sm font-medium text-slate-900">
                    Actions
                </h3>

            </div>


            <div class="divide-y divide-slate-200 rounded-xl border border-slate-200">

                <?php foreach ($buttons as $button): ?>

                    <form method="post">

                        <input
                            type="hidden"
                            name="action"
                            value="<?= htmlspecialchars($button) ?>"
                        >

                        <button
                            type="submit"
                            class="group flex w-full items-center justify-between px-5 py-4 text-left transition hover:bg-slate-50"
                        >

                            <div>

                                <p class="text-sm font-medium text-slate-900">
                                    <?= htmlspecialchars($button) ?>
                                </p>

                                <p class="mt-0.5 text-xs text-slate-500">

                                    <?php

                                    switch ($button) {

                                        case 'Login':
                                            echo 'Test user authentication';
                                            break;

                                        case 'Logout':
                                            echo 'Test user logout';
                                            break;

                                        case 'Create Record':
                                            echo 'Test creating a record';
                                            break;

                                        case 'Update Record':
                                            echo 'Test updating a record';
                                            break;

                                        case 'Delete Record':
                                            echo 'Test deleting a record';
                                            break;

                                        case 'View Record':
                                            echo 'Test viewing a record';
                                            break;

                                        case 'Upload File':
                                            echo 'Test file upload';
                                            break;

                                        case 'Download':
                                            echo 'Test file download';
                                            break;

                                        case 'Search':
                                            echo 'Test record search';
                                            break;

                                        case 'Generate Report':
                                            echo 'Test report generation';
                                            break;

                                        default:
                                            echo 'Test system activity';

                                    }

                                    ?>

                                </p>

                            </div>


                            <span
                                class="text-slate-400 transition-transform group-hover:translate-x-1"
                            >
                                →
                            </span>

                        </button>

                    </form>

                <?php endforeach; ?>

            </div>

        </section>


        <!-- Activity -->

        <section class="mt-10">


            <div class="mb-4">

                <h3 class="text-sm font-medium text-slate-900">
                    Activity
                </h3>

            </div>


            <div class="rounded-xl border border-slate-200 px-5 py-4">


                <?php if ($activityMessage): ?>

                    <div class="flex items-center justify-between gap-4">

                        <div>

                            <p class="text-sm font-medium text-slate-900">
                                <?= htmlspecialchars($activityMessage) ?>
                            </p>

                            <p class="mt-1 text-xs text-slate-500">
                                Activity log inserted into the database.
                            </p>

                        </div>


                        <?php if ($activityStatus === 'success'): ?>

                            <span
                                class="shrink-0 text-xs font-medium text-emerald-600"
                            >
                                Success
                            </span>

                        <?php else: ?>

                            <span
                                class="shrink-0 text-xs font-medium text-red-600"
                            >
                                Failed
                            </span>

                        <?php endif; ?>

                    </div>


                <?php else: ?>

                    <p class="text-sm text-slate-500">
                        No activity yet.
                    </p>

                <?php endif; ?>


            </div>

        </section>


    </main>


    <!-- Footer -->

    <footer class="border-t border-slate-200">

        <div class="mx-auto max-w-6xl px-6 py-6">

            <p class="text-center text-xs text-slate-400">
                IT34A Activity Management System
            </p>

        </div>

    </footer>


</body>

</html>