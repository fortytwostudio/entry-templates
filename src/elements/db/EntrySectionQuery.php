<?php

namespace fortytwostudio\entrytemplates\elements\db;

use craft\db\Query;
use craft\elements\db\ElementQuery;
use craft\db\Table;

/**
 * Content template element query class.
 *
 * @since 1.0.0
 */
class EntrySectionQuery extends ElementQuery
{
	/**
	 * @var int|null The section ID(s) for this query.
	 */
	public array|string|null $sectionIds = null;

	/**
	 * Filters the query results based on the entry type IDs.
	 *
	 * @param int[]|int|null $value The entry type ID(s).
	 * @return static
	 */
	public function sectionIds(array|int|null $value): self
	{
		$this->sectionIds = serialize($value);

		return $this;
	}

	/**
	 * @inheritdoc
	 */
	protected function beforePrepare(): bool
	{
		$this->joinElementTable("entry_templates");

		$this->query->select([
			"entry_templates.id",
			"entry_templates.previewImage",
			"entry_templates.description",
			"entry_templates.sectionIds",
		]);

		$this->subQuery->andWhere([
			"like",
			"entry_templates.sectionIds",
			$this->sectionIds,
		]);

		return parent::beforePrepare();
	}
}
