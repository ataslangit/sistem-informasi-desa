<?php
defined('BASEPATH') || exit('No direct script access allowed');
?>

A PHP Error was encountered

Severity: <?= $severity; ?>
Message:  <?= $message; ?>
Filename: <?= $filepath; ?>
Line Number: <?= $line; ?>

<?php if (defined('SHOW_DEBUG_BACKTRACE') && SHOW_DEBUG_BACKTRACE === true): ?>

Backtrace:
	<?php foreach (debug_backtrace() as $error): ?>
		<?php if (isset($error['file']) && strpos($error['file'], realpath(BASEPATH)) !== 0): ?>

	File: <?= $error['file']; ?>
	Line: <?= $error['line']; ?>
	Function: <?= $error['function']; ?>

		<?php endif ?>

	<?php endforeach ?>
<?php endif ?>