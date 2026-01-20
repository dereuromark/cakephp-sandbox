<?php
/**
 * !!! Auto generated file. Do not directly modify this file. !!!
 * You can either version control this or generate the file on the fly prior to usage/deployment.
 */

namespace App\Dto;

use PhpCollective\Dto\Dto\AbstractImmutableDto;
use RuntimeException;

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
	protected $id;

	/**
	 * @var string|null
	 */
	protected $title;

	/**
	 * @var string|null
	 */
	protected $body;

	/**
	 * @var \App\Dto\AuthorBenchmarkDto|null
	 */
	protected $author;

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
     * @var bool
	 */
	protected const IS_IMMUTABLE = true;

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
	 * This method is only called in lenient mode (ignoreMissing=true),
	 * where unknown fields are silently ignored.
	 *
	 * @param array<string, mixed> $data
	 *
	 * @return void
	 */
	protected function setFromArrayFast(array $data): void {
		if (isset($data['id'])) {
			$this->id = $data['id'];
			$this->_touchedFields['id'] = true;
		}
		if (isset($data['title'])) {
			$this->title = $data['title'];
			$this->_touchedFields['title'] = true;
		}
		if (isset($data['body'])) {
			$this->body = $data['body'];
			$this->_touchedFields['body'] = true;
		}
		if (isset($data['author'])) {
			$value = $data['author'];
			if (is_array($value)) {
				$value = new AuthorBenchmarkDto($value, true);
			}
			$this->author = $value;
			$this->_touchedFields['author'] = true;
		}
		if (isset($data['comments'])) {
			$collection = [];
			foreach ($data['comments'] as $key => $item) {
				if (is_array($item)) {
					$item = new CommentBenchmarkDto($item, true);
				}
				$collection[$key] = $item;
			}
			$this->comments = $collection;
			$this->_touchedFields['comments'] = true;
		}
	}

	/**
	 * Optimized setDefaults - only processes fields with default values.
	 *
	 * @return $this
	 */
	protected function setDefaults() {
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
	public function withId(?int $id = null) {
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
	public function withIdOrFail(int $id) {
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
			throw new RuntimeException('Value not set for field `id` (expected to be not null)');
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
	public function withTitle(?string $title = null) {
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
	public function withTitleOrFail(string $title) {
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
			throw new RuntimeException('Value not set for field `title` (expected to be not null)');
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
	public function withBody(?string $body = null) {
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
	public function withBodyOrFail(string $body) {
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
			throw new RuntimeException('Value not set for field `body` (expected to be not null)');
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
	public function withAuthor(?AuthorBenchmarkDto $author = null) {
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
	public function withAuthorOrFail(AuthorBenchmarkDto $author) {
		$new = clone $this;
		$new->author = $author;
		$new->_touchedFields[static::FIELD_AUTHOR] = true;

		return $new;
	}

	/**
	 * @return \App\Dto\AuthorBenchmarkDto|null
	 */
	public function getAuthor(): ?AuthorBenchmarkDto {
		return $this->author;
	}

	/**
	 * @throws \RuntimeException If value is not set.
	 *
	 * @return \App\Dto\AuthorBenchmarkDto
	 */
	public function getAuthorOrFail(): AuthorBenchmarkDto {
		if ($this->author === null) {
			throw new RuntimeException('Value not set for field `author` (expected to be not null)');
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
	public function withComments(array $comments) {
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
	public function withAddedComment(CommentBenchmarkDto $comment) {
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
     * @phpstan-param array<string, mixed> $data
     * @param array{id: (int | null), title: (string | null), body: (string | null), author: (array{id: (int | null), name: (string | null)} | null), comments: array<int, array{id: (int | null), comment: (string | null), articleId: (int | null), userId: (int | null)}>}|array $data
     * @param bool $ignoreMissing
     * @param string|null $type
     *
     * @return static
	 */
	public static function createFromArray(array $data, bool $ignoreMissing = false, ?string $type = null): static {
		return static::_createFromArrayInternal($data, $ignoreMissing, $type);
	}

}
