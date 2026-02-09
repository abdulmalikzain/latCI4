<?php

if (!function_exists('alert')) {
    function alert()
    {
        $session = session();

        $map = [
            'success' => 'success',
            'warning' => 'warning',
            'error'   => 'error',
            'info'    => 'info'
        ];

        foreach ($map as $key => $icon) {
            if ($session->getFlashdata($key)) {
                return "
                <script>
                Swal.fire({
                    icon: '{$icon}',
                    title: '" . ucfirst($key) . "',
                    text: `" . $session->getFlashdata($key) . "`,
                    confirmButtonText: 'OK'
                });
                </script>
                ";
            }
        }

        return '';
    }
}
