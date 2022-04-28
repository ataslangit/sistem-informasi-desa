<?php
defined('BASEPATH') || exit('No direct script access allowed');
?>

An uncaught Exception was encountered

Type: <?= get_class($exception); ?>
Message: <?= $message; ?>
Filename: <?= $exception->getFile(); ?>
Line Number: <?= $exception->getLine(); ?>

<?php if (defined('SHOW_DEBUG_BACKTRACE') && SHOW_DEBUG_BACKTRACE === true): ?>

Backtrace:
	<?php foreach ($exception->getTrace() as $error): ?>
		<?php if (isset($error['file']) && strpos($error['file'], realpath(BASEPATH)) !== 0): ?>

	File: <?= $error['file']; ?>
	Line: <?= $error['line']; ?>
	Function: <?= $error['function']; ?>

		<?php endif ?>

	<?php endforeach ?>
<?php endif ?>