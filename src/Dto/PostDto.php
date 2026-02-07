<?php
/**
 * !!! Auto generated file. Do not directly modify this file. !!!
 * You can either version control this or generate the file on the fly prior to usage/deployment.
 */

namespace App\Dto;

use PhpCollective\Dto\Dto\AbstractImmutableDto;

/**
 * Post DTO
 *
 * @property int|null $id
 * @property string|null $title
 * @property string|null $content
 * @property string|null $slug
 * @property array<int, \App\Dto\TagDto> $tags
 */
class PostDto extends AbstractImmutableDto {

	/**
	 * @var string
	 */
	public const FIELD_ID = 'id';

	/**
	 * @var string
	 */
	public const FIELD_TITLE = 'title';

	/**
	 * @var string
	 */
	public const FIELD_CONTENT = 'content';

	/**
	 * @var string
	 */
	public const FIELD_SLUG = 'slug';

	/**
	 * @var string
	 */
	public const FIELD_TAGS = 'tags';


	/**
	 * @var int|null
	 */
	protected ?int $id = null;

	/**
	 * @var string|null
	 */
	protected ?string $title = null;

	/**
	 * @var string|null
	 */
	protected ?string $content = null;

	/**
	 * @var string|null
	 */
	protected ?string $slug = null;

	/**
	 * @var array<int, \App\Dto\TagDto>
	 */
	protected $tags;

	/**
	 * Some data is only for debugging for now.
	 *
	 * @var array<string, array<string, mixed>>
	 */
	protected array $_metadata = [
		'id' => [
			'name' => 'id',
			'type' => 'int',
			'required' => false,
			'defaultValue' => null,
			'dto' => null,
			'collectionType' => null,
			'associative' => false,
			'key' => null,
			'serialize' => null,
			'factory' => null,
			'mapFrom' => null,
			'mapTo' => null,
			'transformFrom' => null,
			'transformTo' => null,
		],
		'title' => [
			'name' => 'title',
			'type' => 'string',
			'required' => false,
			'defaultValue' => null,
			'dto' => null,
			'collectionType' => null,
			'associative' => false,
			'key' => null,
			'serialize' => null,
			'factory' => null,
			'mapFrom' => null,
			'mapTo' => null,
			'transformFrom' => null,
			'transformTo' => null,
		],
		'content' => [
			'name' => 'content',
			'type' => 'string',
			'required' => false,
			'defaultValue' => null,
			'dto' => null,
			'collectionType' => null,
			'associative' => false,
			'key' => null,
			'serialize' => null,
			'factory' => null,
			'mapFrom' => null,
			'mapTo' => null,
			'transformFrom' => null,
			'transformTo' => null,
		],
		'slug' => [
			'name' => 'slug',
			'type' => 'string',
			'required' => false,
			'defaultValue' => null,
			'dto' => null,
			'collectionType' => null,
			'associative' => false,
			'key' => null,
			'serialize' => null,
			'factory' => null,
			'mapFrom' => null,
			'mapTo' => null,
			'transformFrom' => null,
			'transformTo' => null,
		],
		'tags' => [
			'name' => 'tags',
			'type' => '\App\Dto\TagDto[]',
			'collectionType' => 'array',
			'required' => false,
			'defaultValue' => null,
			'dto' => null,
			'associative' => false,
			'key' => null,
			'serialize' => null,
			'factory' => null,
			'mapFrom' => null,
			'mapTo' => null,
			'transformFrom' => null,
			'transformTo' => null,
			'singularType' => '\App\Dto\TagDto',
			'singularNullable' => false,
			'singularTypeHint' => '\App\Dto\TagDto',
		],
	];

	/**
	 * @var array<string, array<string, string>>
	 */
	protected array $_keyMap = [
		'underscored' => [
			'id' => 'id',
			'title' => 'title',
			'content' => 'content',
			'slug' => 'slug',
			'tags' => 'tags',
		],
		'dashed' => [
			'id' => 'id',
			'title' => 'title',
			'content' => 'content',
			'slug' => 'slug',
			'tags' => 'tags',
		],
	];

	/**
	 * Whether this DTO is immutable.
	 *
	 * @var bool
	 */
	protected const IS_IMMUTABLE = true;

	/**
	 * Whether this DTO has generated fast-path methods.
	 *
	 * @var bool
	 */
	protected const HAS_FAST_PATH = true;

	/**
	 * Pre-computed setter method names for fast lookup.
	 *
	 * @var array<string, string>
	 */
	protected static array $_setters = [
		'id' => 'withId',
		'title' => 'withTitle',
		'content' => 'withContent',
		'slug' => 'withSlug',
		'tags' => 'withTags',
	];

	/**
	 * Optimized array assignment without dynamic method calls.
	 *
	 * @param array<string, mixed> $data
	 *
	 * @return void
	 */
	protected function setFromArrayFast(array $data): void {
		if (isset($data['id'])) {
			/** @var int|null $value */
			$value = $data['id'];
			$this->id = $value;
			$this->_touchedFields['id'] = true;
		}
		if (isset($data['title'])) {
			/** @var string|null $value */
			$value = $data['title'];
			$this->title = $value;
			$this->_touchedFields['title'] = true;
		}
		if (isset($data['content'])) {
			/** @var string|null $value */
			$value = $data['content'];
			$this->content = $value;
			$this->_touchedFields['content'] = true;
		}
		if (isset($data['slug'])) {
			/** @var string|null $value */
			$value = $data['slug'];
			$this->slug = $value;
			$this->_touchedFields['slug'] = true;
		}
		if (isset($data['tags'])) {
			$collection = [];
			/** @var array $dataItems */
			$dataItems = $data['tags'];
			foreach ($dataItems as $key => $item) {
				if (is_array($item)) {
					$item = new \App\Dto\TagDto($item, true);
				}
				$collection[$key] = $item;
			}
			$this->tags = $collection;
			$this->_touchedFields['tags'] = true;
		}
	}

	/**
	 * Optimized toArray for default type without dynamic dispatch.
	 *
	 * @return array<string, mixed>
	 */
	protected function toArrayFast(): array {
		return [
			'id' => $this->id,
			'title' => $this->title,
			'content' => $this->content,
			'slug' => $this->slug,
			'tags' => (static function (?array $a): array {
				if (!$a) {
					return [];
				}
				$r = [];
				foreach ($a as $k => $v) {
					$r[$k] = $v->toArray();
				}
				return $r;
			})($this->tags),
		];
	}


	/**
	 * Optimized setDefaults - only processes fields with default values.
	 *
	 * @return $this
	 */
	protected function setDefaults(): static {

		return $this;
	}

	/**
	 * Optimized validate - only checks required fields.
	 *
	 * @throws \InvalidArgumentException
	 *
	 * @return void
	 */
	protected function validate(): void {
	}


	/**
	 * @param int|null $id
	 *
	 * @return static
	 */
	public function withId(?int $id = null): static {
		$new = clone $this;
		$new->id = $id;
		$new->_touchedFields[static::FIELD_ID] = true;

		return $new;
	}

	/**
	 * @param int $id
	 *
	 * @return static
	 */
	public function withIdOrFail(int $id): static {
		$new = clone $this;
		$new->id = $id;
		$new->_touchedFields[static::FIELD_ID] = true;

		return $new;
	}

	/**
	 * @return int|null
	 */
	public function getId(): ?int {
		return $this->id;
	}

	/**
	 * @throws \RuntimeException If value is not set.
	 *
	 * @return int
	 */
	public function getIdOrFail(): int {
		if ($this->id === null) {
			throw new \RuntimeException('Value not set for field `id` (expected to be not null)');
		}

		return $this->id;
	}

	/**
	 * @return bool
	 */
	public function hasId(): bool {
		return $this->id !== null;
	}

	/**
	 * @param string|null $title
	 *
	 * @return static
	 */
	public function withTitle(?string $title = null): static {
		$new = clone $this;
		$new->title = $title;
		$new->_touchedFields[static::FIELD_TITLE] = true;

		return $new;
	}

	/**
	 * @param string $title
	 *
	 * @return static
	 */
	public function withTitleOrFail(string $title): static {
		$new = clone $this;
		$new->title = $title;
		$new->_touchedFields[static::FIELD_TITLE] = true;

		return $new;
	}

	/**
	 * @return string|null
	 */
	public function getTitle(): ?string {
		return $this->title;
	}

	/**
	 * @throws \RuntimeException If value is not set.
	 *
	 * @return string
	 */
	public function getTitleOrFail(): string {
		if ($this->title === null) {
			throw new \RuntimeException('Value not set for field `title` (expected to be not null)');
		}

		return $this->title;
	}

	/**
	 * @return bool
	 */
	public function hasTitle(): bool {
		return $this->title !== null;
	}

	/**
	 * @param string|null $content
	 *
	 * @return static
	 */
	public function withContent(?string $content = null): static {
		$new = clone $this;
		$new->content = $content;
		$new->_touchedFields[static::FIELD_CONTENT] = true;

		return $new;
	}

	/**
	 * @param string $content
	 *
	 * @return static
	 */
	public function withContentOrFail(string $content): static {
		$new = clone $this;
		$new->content = $content;
		$new->_touchedFields[static::FIELD_CONTENT] = true;

		return $new;
	}

	/**
	 * @return string|null
	 */
	public function getContent(): ?string {
		return $this->content;
	}

	/**
	 * @throws \RuntimeException If value is not set.
	 *
	 * @return string
	 */
	public function getContentOrFail(): string {
		if ($this->content === null) {
			throw new \RuntimeException('Value not set for field `content` (expected to be not null)');
		}

		return $this->content;
	}

	/**
	 * @return bool
	 */
	public function hasContent(): bool {
		return $this->content !== null;
	}

	/**
	 * @param string|null $slug
	 *
	 * @return static
	 */
	public function withSlug(?string $slug = null): static {
		$new = clone $this;
		$new->slug = $slug;
		$new->_touchedFields[static::FIELD_SLUG] = true;

		return $new;
	}

	/**
	 * @param string $slug
	 *
	 * @return static
	 */
	public function withSlugOrFail(string $slug): static {
		$new = clone $this;
		$new->slug = $slug;
		$new->_touchedFields[static::FIELD_SLUG] = true;

		return $new;
	}

	/**
	 * @return string|null
	 */
	public function getSlug(): ?string {
		return $this->slug;
	}

	/**
	 * @throws \RuntimeException If value is not set.
	 *
	 * @return string
	 */
	public function getSlugOrFail(): string {
		if ($this->slug === null) {
			throw new \RuntimeException('Value not set for field `slug` (expected to be not null)');
		}

		return $this->slug;
	}

	/**
	 * @return bool
	 */
	public function hasSlug(): bool {
		return $this->slug !== null;
	}

	/**
	 * @param array<int, \App\Dto\TagDto> $tags
	 *
	 * @return static
	 */
	public function withTags(array $tags): static {
		$new = clone $this;
		$new->tags = $tags;
		$new->_touchedFields[static::FIELD_TAGS] = true;

		return $new;
	}

	/**
	 * @return array<int, \App\Dto\TagDto>
	 */
	public function getTags(): array {
		if ($this->tags === null) {
			return [];
		}

		return $this->tags;
	}

	/**
	 * @return bool
	 */
	public function hasTags(): bool {
		if ($this->tags === null) {
			return false;
		}

		return count($this->tags) > 0;
	}
	/**
	 * @param \App\Dto\TagDto $tag
	 * @return static
	 */
	public function withAddedTag(\App\Dto\TagDto $tag): static {
		$new = clone $this;

		if ($new->tags === null) {
			$new->tags = [];
		}

		$new->tags[] = $tag;
		$new->_touchedFields[static::FIELD_TAGS] = true;

		return $new;
	}

	/**
	 * @param string|null $type
	 * @param array<string>|null $fields
	 * @param bool $touched
	 *
	 * @return array{id: int|null, title: string|null, content: string|null, slug: string|null, tags: array<int, array{id: int|null, label: string|null, slug: string|null, counter: int|null, _joinData: array{id: int|null, tagId: int|null, fkId: int|null, fkModel: string|null, created: \Cake\I18n\DateTime|null}|null}>}
	 */
	public function toArray(?string $type = null, ?array $fields = null, bool $touched = false): array {
		/** @var array{id: int|null, title: string|null, content: string|null, slug: string|null, tags: array<int, array{id: int|null, label: string|null, slug: string|null, counter: int|null, _joinData: array{id: int|null, tagId: int|null, fkId: int|null, fkModel: string|null, created: \Cake\I18n\DateTime|null}|null}>} $result */
		$result = $this->_toArrayInternal($type, $fields, $touched);

		return $result;
	}

	/**
	 * @param array{id: int|null, title: string|null, content: string|null, slug: string|null, tags: array<int, array{id: int|null, label: string|null, slug: string|null, counter: int|null, _joinData: array{id: int|null, tagId: int|null, fkId: int|null, fkModel: string|null, created: \Cake\I18n\DateTime|null}|null}>} $data
	 * @phpstan-param array<string, mixed> $data
	 * @param bool $ignoreMissing
	 * @param string|null $type
	 *
	 * @return static
	 */
	public static function createFromArray(array $data, bool $ignoreMissing = false, ?string $type = null): static {
		return static::_createFromArrayInternal($data, $ignoreMissing, $type);
	}

}
