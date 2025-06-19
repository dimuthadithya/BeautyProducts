<?php
require_once('../config/db_conn.php');
session_start();

// Check if user is logged in and is admin
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
    header('Location: ../login.php');
    exit;
}

// Update message status
if (isset($_POST['message_id']) && isset($_POST['status'])) {
    $message_id = (int)$_POST['message_id'];
    $status = mysqli_real_escape_string($conn, $_POST['status']);

    $query = "UPDATE messages SET status = ? WHERE message_id = ?";
    $stmt = mysqli_prepare($conn, $query);
    mysqli_stmt_bind_param($stmt, "si", $status, $message_id);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_close($stmt);

    header('Content-Type: application/json');
    echo json_encode(['success' => true]);
    exit;
}

// Fetch messages
$query = "SELECT * FROM messages ORDER BY created_at DESC";
$result = mysqli_query($conn, $query);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Messages - Beauty Store Admin</title>
    <?php include('include/head.php'); ?>
    <style>
        .message-card {
            transition: transform 0.2s;
        }

        .message-card:hover {
            transform: translateY(-2px);
        }

        .unread {
            border-left: 4px solid #0d6efd;
        }

        .message-actions {
            opacity: 0.7;
            transition: opacity 0.2s;
        }

        .message-card:hover .message-actions {
            opacity: 1;
        }
    </style>
</head>

<body>
    <div class="wrapper">
        <!-- Sidebar -->
        <?php include('include/sidebar.php'); ?>

        <!-- Main Content -->
        <div class="main-content">
            <?php
            $pageTitle = "Customer Messages";
            include('include/header.php');
            ?>

            <!-- Content Area -->
            <div class="content">
                <div class="container-fluid">
                    <div class="row">
                        <?php while ($message = mysqli_fetch_assoc($result)) : ?>
                            <div class="col-12 mb-4">
                                <div class="card message-card <?php echo $message['status'] === 'unread' ? 'unread' : ''; ?>">
                                    <div class="card-body">
                                        <div class="d-flex justify-content-between align-items-start mb-3">
                                            <div>
                                                <h5 class="card-title"><?php echo htmlspecialchars($message['subject']); ?></h5>
                                                <h6 class="card-subtitle text-muted">
                                                    From: <?php echo htmlspecialchars($message['name']); ?>
                                                    (<?php echo htmlspecialchars($message['email']); ?>)
                                                </h6>
                                            </div>
                                            <div class="message-actions">
                                                <a href="mailto:<?php echo htmlspecialchars($message['email']); ?>?subject=Re: <?php echo htmlspecialchars($message['subject']); ?>"
                                                    class="btn btn-sm btn-primary me-2"
                                                    onclick="markAsReplied(<?php echo $message['message_id']; ?>)">
                                                    <i class="fas fa-reply"></i> Reply
                                                </a>
                                                <?php if ($message['status'] === 'unread') : ?>
                                                    <button class="btn btn-sm btn-outline-primary"
                                                        onclick="markAsRead(<?php echo $message['message_id']; ?>, this)">
                                                        <i class="fas fa-check"></i> Mark as Read
                                                    </button>
                                                <?php endif; ?>
                                            </div>
                                        </div>
                                        <p class="card-text"><?php echo nl2br(htmlspecialchars($message['message'])); ?></p>
                                        <div class="d-flex justify-content-between align-items-center mt-3">
                                            <small class="text-muted">
                                                Received: <?php echo date('F j, Y g:i A', strtotime($message['created_at'])); ?>
                                            </small>
                                            <span class="badge bg-<?php
                                                                    echo match ($message['status']) {
                                                                        'unread' => 'primary',
                                                                        'read' => 'secondary',
                                                                        'replied' => 'success',
                                                                        default => 'secondary'
                                                                    };
                                                                    ?>">
                                                <?php echo ucfirst($message['status']); ?>
                                            </span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        <?php endwhile; ?>

                        <?php if (mysqli_num_rows($result) === 0) : ?>
                            <div class="col-12">
                                <div class="alert alert-info">
                                    No messages found.
                                </div>
                            </div>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        async function updateMessageStatus(messageId, status) {
            try {
                const formData = new FormData();
                formData.append('message_id', messageId);
                formData.append('status', status);

                const response = await fetch('messages.php', {
                    method: 'POST',
                    body: formData
                });

                const data = await response.json();
                if (data.success) {
                    return true;
                }
            } catch (error) {
                console.error('Error:', error);
            }
            return false;
        }

        async function markAsRead(messageId, button) {
            if (await updateMessageStatus(messageId, 'read')) {
                const card = button.closest('.message-card');
                card.classList.remove('unread');
                button.remove();
                const badge = card.querySelector('.badge');
                badge.className = 'badge bg-secondary';
                badge.textContent = 'Read';
            }
        }

        async function markAsReplied(messageId) {
            await updateMessageStatus(messageId, 'replied');
            const badge = document.querySelector(`[data-message-id="${messageId}"] .badge`);
            if (badge) {
                badge.className = 'badge bg-success';
                badge.textContent = 'Replied';
            }
        }
    </script>
</body>

</html>