<?php

namespace fortytwostudio\entrytemplates\migrations;

use Craft;
use craft\db\Migration;

/**
 * Install migration.
 */
class Install extends Migration
{
	// Public Properties
	// =========================================================================

	/**
	 * @var ?string The database driver to use
	 */
	public ?string $driver = null;

	/**
	 * @inheritdoc
	 */
	public function safeUp(): bool
	{
		$this->driver = Craft::$app->getConfig()->getDb()->driver;
		if ($this->createTables()) {
			// Refresh the db schema caches
			Craft::$app->db->schema->refresh();
		}

		return true;
	}

	/**
	 * @inheritdoc
	 */
	public function safeDown(): bool
	{
		$this->dropTableIfExists("{{%entry_templates}}");
		return true;
	}

	// Protected Properties
	// =========================================================================

	/**
	 * @return bool
	 */
	protected function createTables(): bool
	{
		$tablesCreated = false;

		$tableSchema = Craft::$app->db->schema->getTableSchema(
			"{{%entry_templates}}"
		);
		if ($tableSchema === null) {
			$tablesCreated = true;

			$this->createTable("{{%entry_templates}}", [
				"id" => $this->integer()->notNull(),
				"typeId" => $this->integer()->notNull(),
				"typeId" => $this->integer()->notNull(),
				"sectionIds" => $this->string(),
				"previewImage" => $this->integer(),
				"description" => $this->string(),

				"PRIMARY KEY([[id]])",
			]);
			$this->createIndex(null, "{{%entry_templates}}", ["typeId"], false);
			$this->addForeignKey(
				null,
				"{{%entry_templates}}",
				["id"],
				"{{%elements}}",
				["id"],
				"CASCADE",
				null
			);
			$this->addForeignKey(
				null,
				"{{%entry_templates}}",
				["typeId"],
				"{{%entrytypes}}",
				["id"],
				"CASCADE",
				null
			);

			return true;
		}

		return $tablesCreated;
	}
}
