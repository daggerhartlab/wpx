<?php

namespace Wpx\Admin;

/**
 * Admin page for viewing log files.
 */
abstract class LogsFileViewer extends AdminPageBase {

	/**
	 * Location of the log files.
	 *
	 * @var string
	 */
	protected $folder;

	/**
	 * @param string $folder
	 */
	public function __construct(string $folder) {
		$this->folder = $folder;
		parent::__construct();
	}

	/**
	 * {@inheritDoc}
	 */
	public function actions() {
		return [
			'view-logs' => [$this, 'actionViewLogs'],
		];
	}

	/**
	 * {@inheritDoc}
	 */
	public function content() {
		$filename = $_GET['log-file'] ?? null;
		?>
		<div id="poststuff" class="wpx">
			<div class="postbox">
				<div class="postbox-header">
					<h2><?= __( 'Log Files' ) ?></h2>
				</div>
				<div class="inside">
					<?= $this->actionShowLogsForm() ?>
				</div>
			</div>

			<?php if ($filename) : ?>
				<div class="postbox">
					<div class="postbox-header">
						<h2><?= __( 'File Contents' ) ?></h2>
					</div>
					<div class="inside">
						<?= $this->showLogFile($filename) ?>
					</div>
				</div>
			<?php endif ?>
		</div>
		<?php
	}

	/**
	 * @return false|string
	 */
	public function actionShowLogsForm() {
		ob_start();
		$log_files = glob($this->folder . '/*.log');
		rsort($log_files);
		$log_files = array_map('basename', $log_files);
		?>
		<form method="POST" action="<?= $this->actionPath('view-logs') ?>">
			<p>
				<label for="log-file">
					Log File:
					<select name="log-file" id="log-file">
						<?php foreach ($log_files as $log_file) { ?>
							<option value="<?= $log_file ?>"><?= $log_file ?></option>
						<?php } ?>
					</select>
				</label>
			</p>
			<p>
				<input class="button button-primary" type="submit" value="Submit">
			</p>
		</form>
		<?php
		return ob_get_clean();
	}

	/**
	 * @return array|string[]
	 */
	public function actionViewLogs() {
		$this->validateAction();
		if (isset($_POST['log-file']) && file_exists($this->folder . '/' . $_POST['log-file'])) {
			return $this->result(
				"File loaded: {$_POST['log-file']}",
				$this->pagePath() . '&log-file=' . $_POST['log-file']
			);
		}

		return $this->error("File not found: {$_POST['log-file']}");
	}

	/**
	 * Show log file contents.
	 *
	 * @param string $filename
	 *
	 * @return false|string
	 */
	public function showLogFile(string $filename) {
		$file =  "{$this->folder}/{$filename}";
		if (!file_exists($file)) {
			return '';
		}
		ob_start();
		?>
		<pre style="padding: 4px 6px;"><?= file_get_contents($file) ?></pre>
		<?php
		return ob_get_clean();
	}
}
