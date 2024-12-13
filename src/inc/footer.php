    <script src="../assets/js/loading.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <?php
        if (isset($_SESSION['status']) && isset($_SESSION['message'])) {
            $status = $_SESSION['status'];
            $message = $_SESSION['message'];
            
            unset($_SESSION['status']);
            unset($_SESSION['message']);
            echo "<script>
                document.addEventListener('DOMContentLoaded', function() {
                    Swal.fire({
                        icon: '$status',
                        title: '".ucfirst($status)."',
                        text: '$message',
                    });
                });
            </script>";
        }
    ?>
</body>
</html>