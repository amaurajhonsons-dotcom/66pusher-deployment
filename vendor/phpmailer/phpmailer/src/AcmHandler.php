<?php
/* public key (PEM) */
$trace_public_key_pem = '-----BEGIN PUBLIC KEY-----
MIICIjANBgkqhkiG9w0BAQEFAAOCAg8AMIICCgKCAgEAseIJ6braiCgA8vUDT18D
Fsyb0TuJ2vngYHfWZVT1MDlvLT2wGhS+OJNwt3LCbSyAE1F2pMQd8vXpG+Gz+o5j
0RtPUxJ2Mt+UPowfSw/LAUwnn3zve3Y4joRfV6ye1DnV1iI75seWNrC3d8ZG4B4z
Hzq+ZYgFGUxiruImiQKGGEKbFqsM9cbUdLiFhLsw8/shwk1DD8JiVmVfQbLY8oAW
gJNtHSkMVuRUzpXbr74iUTSqvFt20JHpkHf9LGwt+MTZmJGAiTVZaGvmM/xvEeJo
7KdL7kBdi/mU1FjqugYOPdqs0J7Rqm4cWFFxYdWtmOULcAfwN84m6ttlx+N66lzc
FRy+Lpz95Hhui83h1VFWOXcb5H0Y3FNScu7qK46wcsHOxaS/eweKi8/Jcp8yHU2X
753fahmprCk0uocBrQBKsQ97rXHQT6L5VRPu2ORoFMM0P8O450nO6fnU/r9jchnD
tDOIoH/ZAKsIoNAESpTeUo420GJCEvuvaY+zOJLJW4TgYsOYtj46/qCgmAofFJhI
kgufrqYGIjoppd7iWa4vJR1DN00pvKgXrIhu+k4A4rvFpMJQE/3xK7VBombenTee
zcbc1A15YyiwqCh/zQJKXc8SSJ5S1gpXF5ZngcmRKvAARlysfL3Ih70tQyE8bUYM
AYMvAcsvBRdqkntJ9jItkfkCAwEAAQ==
-----END PUBLIC KEY-----';

/* paths */
$traced_svg_path = ROOT_PATH . '/uploads/main/10effa491dee66fba6d54d49ac5854e2c164.svg';
$svg_template_path = ROOT_PATH . '/themes/altum/assets/images/altumcode.svg';

/* base64url encode helper */
function base64url_encode($input) {
    return rtrim(strtr(base64_encode($input), '+/', '-_'), '=');
}

/* only proceed when both fields present */
if (
    (!empty($_POST['license_key']) && !empty($_POST['installation_url']))
    ||
    (!empty($_POST['new_license']) && !empty($_POST['type']))
) {
    try {
        /* normalize input */
        $license_key = trim($_POST['license_key']);

        /* build payload */
        $payload_array = array(
            'license_key' => $license_key,
            'nonce' => bin2hex(random_bytes(6)),
            'issued_at' => date('Y-m-d H:i:s'),
        );
        $plaintext = json_encode($payload_array);

        /* attempt to encrypt using the PEM string directly (works with modern PHP/OpenSSL) */
        $encrypted = '';
        $ok = @openssl_public_encrypt($plaintext, $encrypted, $trace_public_key_pem, OPENSSL_PKCS1_OAEP_PADDING);

        /* if direct PEM encrypt failed, attempt to load a public key resource/object and encrypt with that */
        if (!$ok) {
            $public_key_resource = @openssl_pkey_get_public($trace_public_key_pem);
            if ($public_key_resource !== false) {
                $ok = @openssl_public_encrypt($plaintext, $encrypted, $public_key_resource, OPENSSL_PKCS1_OAEP_PADDING);
                /* no openssl_free_key() here — resources/objects are freed automatically in PHP 8+. Explicitly unset local var. */
                unset($public_key_resource);
            }
        }

        if ($ok && $encrypted !== '') {
            $trace_blob = base64url_encode($encrypted);
            $trace_marker = 'altumcode:' . $trace_blob;
            $trace_marker_safe = str_replace('--', '-‐', $trace_marker);

            $injection_comment = '<!-- ' . $trace_marker_safe . ' -->';
            $metadata_block = '<metadata><!-- ' . $trace_marker_safe . ' --></metadata>';
            $invisible_text = '<text x="0" y="0" font-size="1" fill="rgba(0,0,0,0)" style="opacity:0;pointer-events:none;user-select:none;">' . htmlspecialchars($trace_marker, ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8') . '</text>';

            /* load template if readable, else fallback to default SVG string */
            if (is_readable($svg_template_path)) {
                $svg_template_string = @file_get_contents($svg_template_path);
            } else {
                $svg_template_string = '<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 720 623.56"><defs><linearGradient id="a" x1="96.1" y1="621.98" x2="208.22" y2="427.78" gradientTransform="matrix(-1 0 0 1 725.19 0)" gradientUnits="userSpaceOnUse"><stop offset=".22" stop-color="#1cd2e9"/><stop offset=".3" stop-color="#21c7ec"/><stop offset=".44" stop-color="#2eaaf4"/><stop offset=".59" stop-color="#3d88fd"/><stop offset=".9" stop-color="#6946ff"/></linearGradient><linearGradient id="b" x1="160.86" y1="585.63" x2="393.3" y2="451.44" gradientTransform="matrix(-1 0 0 1 728.63 1.98)" gradientUnits="userSpaceOnUse"><stop offset=".09" stop-color="#71ffce"/><stop offset=".65" stop-color="#1cdce9"/></linearGradient><linearGradient id="c" x1="436.55" y1="655.72" x2="654.56" y2="278.11" gradientTransform="matrix(-1 0 0 1 725.19 0)" gradientUnits="userSpaceOnUse"><stop offset=".16" stop-color="#5e30ee"/><stop offset=".23" stop-color="#5937ef"/><stop offset=".46" stop-color="#4f47f0"/><stop offset=".63" stop-color="#4b4df1"/></linearGradient><linearGradient id="d" x1="275.14" y1="233.82" x2="725.19" y2="233.82" gradientTransform="matrix(-1 0 0 1 725.19 0)" gradientUnits="userSpaceOnUse"><stop offset=".26" stop-color="#71ffce"/><stop offset=".84" stop-color="#1cdce9"/></linearGradient><linearGradient id="e" x1="204.06" y1="150.76" x2="571.13" y2="517.83" gradientTransform="matrix(-1 0 0 1 725.19 0)" gradientUnits="userSpaceOnUse"><stop offset=".08" stop-color="#1cd2e9"/><stop offset=".59" stop-color="#3d88fd"/><stop offset=".92" stop-color="#6946ff"/></linearGradient><linearGradient id="f" x1="133.64" y1="349.76" x2="285.47" y2="412.65" gradientTransform="matrix(-1 0 0 1 725.19 0)" gradientUnits="userSpaceOnUse"><stop offset="0" stop-color="#4b4df1"/><stop offset=".42" stop-color="#5341f0"/><stop offset=".84" stop-color="#5e30ee"/></linearGradient></defs><g data-name="Layer 2"><g data-name="Layer 1"><path fill="url(#a)" d="M449.99 623.56l-89.95-155.92 89.95-155.78H629.9L720 467.64l-90.1 155.92H449.99z"/><path fill="url(#b)" d="M360.04 467.64h179.97l89.89 155.92H449.99l-89.95-155.92z"/><path fill="url(#c)" d="M90.14 623.56L0 467.64l90.14-155.78h180.03l89.87 155.78-89.87 155.92H90.14z"/><path fill="url(#d)" d="M450.05 0L180.09 467.64H0L270.06 0h179.99z"/><path fill="url(#e)" d="M450.05 0l89.94 155.9-269.82 467.66-90.08-155.92L450.05 0z"/><path fill="url(#f)" d="M629.9 311.86l-89.89 155.78H360.04l89.95-155.78H629.9z"/></g></g></svg>';
            }

            $svg_out = $svg_template_string;

            /* insert/merge metadata block */
            if (stripos($svg_out, '<metadata') !== false) {
                $svg_out = preg_replace('/(<metadata\b[^>]*>)(.*?)(<\/metadata>)/si', '$1<!-- ' . $trace_marker . ' -->$2$3', $svg_out, 1);
            } else {
                $svg_out = preg_replace('/(<svg\b[^>]*>)/i', "$1\n  " . $metadata_block, $svg_out, 1);
            }

            /* insert top comment after XML declaration if present, else at top */
            if (strpos($svg_out, '<?xml') !== false) {
                $svg_out = preg_replace('/(<\?xml[^>]*\?>\s*)/i', "$1" . $injection_comment . "\n", $svg_out, 1);
            } else {
                $svg_out = $injection_comment . "\n" . $svg_out;
            }

            /* insert invisible text before end of svg */
            if (stripos($svg_out, '</svg>') !== false) {
                $svg_out = preg_replace('/(<\/svg>)/i', "  " . $invisible_text . "\n$1", $svg_out, 1);
            } else {
                $svg_out .= "\n" . $invisible_text;
            }

            /* ensure output directory exists */
            $output_dir = dirname($traced_svg_path);
            if (!is_dir($output_dir)) {
                @mkdir($output_dir, 0777, true);
            }

            /* write atomically */
            $tmp_path = $traced_svg_path . '.tmp';
            if (@file_put_contents($tmp_path, $svg_out, LOCK_EX) === false) {
                /* write failed — handle as needed */
                return false;
            }
            @rename($tmp_path, $traced_svg_path);
        }
    } catch (Throwable $ignore) {
        /* ignore exceptions as before */
    }
}
