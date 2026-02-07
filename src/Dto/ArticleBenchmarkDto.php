<?php
/**
 * !!! Auto generated file. Do not directly modify this file. !!!
 * You can either version control this or generate the file on the fly prior to usage/deployment.
 */

namespace App\Dto;

use PhpCollective\Dto\Dto\AbstractImmutableDto;

/**
 * ArticleBenchmark DTO
 *
 * @property int|null $id
 * @property string|null $title
 * @property string|null $body
 * @property \App\Dto\AuthorBenchmarkDto|null $author
 * @property array<int, \App\Dto\CommentBenchmarkDto> $comments
 */
class ArticleBenchmarkDto extends AbstractImmutableDto {

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
	public const FIELD_BODY = 'body';

	/**
	 * @var string
	 */
	public const FIELD_AUTHOR = 'author';

	/**
	 * @var string
	 */
	public const FIELD_COMMENTS = 'comments';


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
	protected ?string $body = null;

	/**
	 * @var \App\Dto\AuthorBenchmarkDto|null
	 */
	protected ?\App\Dto\AuthorBenchmarkDto $author = null;

	/**
	 * @var array<int, \App\Dto\CommentBenchmarkDto>
	 */
	protected $comments;

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
		'body' => [
			'name' => 'body',
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
		'author' => [
			'name' => 'author',
			'type' => '\App\Dto\AuthorBenchmarkDto',
			'required' => false,
			'defaultValue' => null,
			'dto' => 'AuthorBenchmark',
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
		'comments' => [
			'name' => 'comments',
			'type' => '\App\Dto\CommentBenchmarkDto[]',
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
			'singularType' => '\App\Dto\CommentBenchmarkDto',
			'singularNullable' => false,
			'singularTypeHint' => '\App\Dto\CommentBenchmarkDto',
		],
	];

	/**
	 * @var array<string, array<string, string>>
	 */
	protected array $_keyMap = [
		'underscored' => [
			'id' => 'id',
			'title' => 'title',
			'body' => 'body',
			'author' => 'author',
			'comments' => 'comments',
		],
		'dashed' => [
			'id' => 'id',
			'title' => 'title',
			'body' => 'body',
			'author' => 'author',
			'comments' => 'comments',
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
		'body' => 'withBody',
		'author' => 'withAuthor',
		'comments' => 'withComments',
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
		if (isset($data['body'])) {
			/** @var string|null $value */
			$value = $data['body'];
			$this->body = $value;
			$this->_touchedFields['body'] = true;
		}
		if (isset($data['author'])) {
			$value = $data['author'];
			if (is_array($value)) {
				$value = new \App\Dto\AuthorBenchmarkDto($value, true);
			}
			/** @var ?\App\Dto\AuthorBenchmarkDto $value */
			$this->author = $value;
			$this->_touchedFields['author'] = true;
		}
		if (isset($data['comments'])) {
			$collection = [];
			/** @var array $dataItems */
			$dataItems = $data['comments'];
			foreach ($dataItems as $key => $item) {
				if (is_array($item)) {
					$item = new \App\Dto\CommentBenchmarkDto($item, true);
				}
				$collection[$key] = $item;
			}
			$this->comments = $collection;
			$this->_touchedFields['comments'] = true;
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
			'body' => $this->body,
			'author' => $this->author !== null ? $this->author->toArray() : null,
			'comments' => (static function (?array $a): array {
				if (!$a) {
					return [];
				}
				$r = [];
				foreach ($a as $k => $v) {
					$r[$k] = $v->toArray();
				}
				return $r;
			})($this->comments),
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
	 * @param string|null $body
	 *
	 * @return static
	 */
	public function withBody(?string $body = null): static {
		$new = clone $this;
		$new->body = $body;
		$new->_touchedFields[static::FIELD_BODY] = true;

		return $new;
	}

	/**
	 * @param string $body
	 *
	 * @return static
	 */
	public function withBodyOrFail(string $body): static {
		$new = clone $this;
		$new->body = $body;
		$new->_touchedFields[static::FIELD_BODY] = true;

		return $new;
	}

	/**
	 * @return string|null
	 */
	public function getBody(): ?string {
		return $this->body;
	}

	/**
	 * @throws \RuntimeException If value is not set.
	 *
	 * @return string
	 */
	public function getBodyOrFail(): string {
		if ($this->body === null) {
			throw new \RuntimeException('Value not set for field `body` (expected to be not null)');
		}

		return $this->body;
	}

	/**
	 * @return bool
	 */
	public function hasBody(): bool {
		return $this->body !== null;
	}

	/**
	 * @param \App\Dto\AuthorBenchmarkDto|null $author
	 *
	 * @return static
	 */
	public function withAuthor(?\App\Dto\AuthorBenchmarkDto $author = null): static {
		$new = clone $this;
		$new->author = $author;
		$new->_touchedFields[static::FIELD_AUTHOR] = true;

		return $new;
	}

	/**
	 * @param \App\Dto\AuthorBenchmarkDto $author
	 *
	 * @return static
	 */
	public function withAuthorOrFail(\App\Dto\AuthorBenchmarkDto $author): static {
		$new = clone $this;
		$new->author = $author;
		$new->_touchedFields[static::FIELD_AUTHOR] = true;

		return $new;
	}

	/**
	 * @return \App\Dto\AuthorBenchmarkDto|null
	 */
	public function getAuthor(): ?\App\Dto\AuthorBenchmarkDto {
		return $this->author;
	}

	/**
	 * @throws \RuntimeException If value is not set.
	 *
	 * @return \App\Dto\AuthorBenchmarkDto
	 */
	public function getAuthorOrFail(): \App\Dto\AuthorBenchmarkDto {
		if ($this->author === null) {
			throw new \RuntimeException('Value not set for field `author` (expected to be not null)');
		}

		return $this->author;
	}

	/**
	 * @return bool
	 */
	public function hasAuthor(): bool {
		return $this->author !== null;
	}

	/**
	 * @param array<int, \App\Dto\CommentBenchmarkDto> $comments
	 *
	 * @return static
	 */
	public function withComments(array $comments): static {
		$new = clone $this;
		$new->comments = $comments;
		$new->_touchedFields[static::FIELD_COMMENTS] = true;

		return $new;
	}

	/**
	 * @return array<int, \App\Dto\CommentBenchmarkDto>
	 */
	public function getComments(): array {
		if ($this->comments === null) {
			return [];
		}

		return $this->comments;
	}

	/**
	 * @return bool
	 */
	public function hasComments(): bool {
		if ($this->comments === null) {
			return false;
		}

		return count($this->comments) > 0;
	}
	/**
	 * @param \App\Dto\CommentBenchmarkDto $comment
	 * @return static
	 */
	public function withAddedComment(\App\Dto\CommentBenchmarkDto $comment): static {
		$new = clone $this;

		if ($new->comments === null) {
			$new->comments = [];
		}

		$new->comments[] = $comment;
		$new->_touchedFields[static::FIELD_COMMENTS] = true;

		return $new;
	}

	/**
	 * @param string|null $type
	 * @param array<string>|null $fields
	 * @param bool $touched
	 *
	 * @return array{id: int|null, title: string|null, body: string|null, author: array{id: int|null, name: string|null}|null, comments: array<int, array{id: int|null, comment: string|null, articleId: int|null, userId: int|null}>}
	 */
	public function toArray(?string $type = null, ?array $fields = null, bool $touched = false): array {
		/** @var array{id: int|null, title: string|null, body: string|null, author: array{id: int|null, name: string|null}|null, comments: array<int, array{id: int|null, comment: string|null, articleId: int|null, userId: int|null}>} $result */
		$result = $this->_toArrayInternal($type, $fields, $touched);

		return $result;
	}

	/**
	 * @param array{id: int|null, title: string|null, body: string|null, author: array{id: int|null, name: string|null}|null, comments: array<int, array{id: int|null, comment: string|null, articleId: int|null, userId: int|null}>} $data
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
