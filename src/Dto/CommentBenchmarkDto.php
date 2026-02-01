<?php
/**
 * !!! Auto generated file. Do not directly modify this file. !!!
 * You can either version control this or generate the file on the fly prior to usage/deployment.
 */

namespace App\Dto;

use PhpCollective\Dto\Dto\AbstractImmutableDto;

/**
 * CommentBenchmark DTO
 *
 * @property int|null $id
 * @property string|null $comment
 * @property int|null $articleId
 * @property int|null $userId
 */
class CommentBenchmarkDto extends AbstractImmutableDto {

	/**
	 * @var string
	 */
	public const FIELD_ID = 'id';

	/**
	 * @var string
	 */
	public const FIELD_COMMENT = 'comment';

	/**
	 * @var string
	 */
	public const FIELD_ARTICLE_ID = 'articleId';

	/**
	 * @var string
	 */
	public const FIELD_USER_ID = 'userId';


	/**
	 * @var int|null
	 */
	protected $id;

	/**
	 * @var string|null
	 */
	protected $comment;

	/**
	 * @var int|null
	 */
	protected $articleId;

	/**
	 * @var int|null
	 */
	protected $userId;

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
		'comment' => [
			'name' => 'comment',
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
		'articleId' => [
			'name' => 'articleId',
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
		'userId' => [
			'name' => 'userId',
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
	];

	/**
	* @var array<string, array<string, string>>
	*/
	protected array $_keyMap = [
		'underscored' => [
			'id' => 'id',
			'comment' => 'comment',
			'article_id' => 'articleId',
			'user_id' => 'userId',
		],
		'dashed' => [
			'id' => 'id',
			'comment' => 'comment',
			'article-id' => 'articleId',
			'user-id' => 'userId',
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
		'comment' => 'withComment',
		'articleId' => 'withArticleId',
		'userId' => 'withUserId',
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
			$this->id = $data['id'];
			$this->_touchedFields['id'] = true;
		}
		if (isset($data['comment'])) {
			$this->comment = $data['comment'];
			$this->_touchedFields['comment'] = true;
		}
		if (isset($data['articleId'])) {
			$this->articleId = $data['articleId'];
			$this->_touchedFields['articleId'] = true;
		}
		if (isset($data['userId'])) {
			$this->userId = $data['userId'];
			$this->_touchedFields['userId'] = true;
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
			'comment' => $this->comment,
			'articleId' => $this->articleId,
			'userId' => $this->userId,
		];
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
	 * @param string|null $comment
	 *
	 * @return static
	 */
	public function withComment(?string $comment = null) {
		$new = clone $this;
		$new->comment = $comment;
		$new->_touchedFields[static::FIELD_COMMENT] = true;

		return $new;
	}

	/**
	 * @param string $comment
	 *
	 * @return static
	 */
	public function withCommentOrFail(string $comment) {
		$new = clone $this;
		$new->comment = $comment;
		$new->_touchedFields[static::FIELD_COMMENT] = true;

		return $new;
	}

	/**
	 * @return string|null
	 */
	public function getComment(): ?string {
		return $this->comment;
	}

	/**
	 * @throws \RuntimeException If value is not set.
	 *
	 * @return string
	 */
	public function getCommentOrFail(): string {
		if ($this->comment === null) {
			throw new \RuntimeException('Value not set for field `comment` (expected to be not null)');
		}

		return $this->comment;
	}

	/**
	 * @return bool
	 */
	public function hasComment(): bool {
		return $this->comment !== null;
	}

	/**
	 * @param int|null $articleId
	 *
	 * @return static
	 */
	public function withArticleId(?int $articleId = null) {
		$new = clone $this;
		$new->articleId = $articleId;
		$new->_touchedFields[static::FIELD_ARTICLE_ID] = true;

		return $new;
	}

	/**
	 * @param int $articleId
	 *
	 * @return static
	 */
	public function withArticleIdOrFail(int $articleId) {
		$new = clone $this;
		$new->articleId = $articleId;
		$new->_touchedFields[static::FIELD_ARTICLE_ID] = true;

		return $new;
	}

	/**
	 * @return int|null
	 */
	public function getArticleId(): ?int {
		return $this->articleId;
	}

	/**
	 * @throws \RuntimeException If value is not set.
	 *
	 * @return int
	 */
	public function getArticleIdOrFail(): int {
		if ($this->articleId === null) {
			throw new \RuntimeException('Value not set for field `articleId` (expected to be not null)');
		}

		return $this->articleId;
	}

	/**
	 * @return bool
	 */
	public function hasArticleId(): bool {
		return $this->articleId !== null;
	}

	/**
	 * @param int|null $userId
	 *
	 * @return static
	 */
	public function withUserId(?int $userId = null) {
		$new = clone $this;
		$new->userId = $userId;
		$new->_touchedFields[static::FIELD_USER_ID] = true;

		return $new;
	}

	/**
	 * @param int $userId
	 *
	 * @return static
	 */
	public function withUserIdOrFail(int $userId) {
		$new = clone $this;
		$new->userId = $userId;
		$new->_touchedFields[static::FIELD_USER_ID] = true;

		return $new;
	}

	/**
	 * @return int|null
	 */
	public function getUserId(): ?int {
		return $this->userId;
	}

	/**
	 * @throws \RuntimeException If value is not set.
	 *
	 * @return int
	 */
	public function getUserIdOrFail(): int {
		if ($this->userId === null) {
			throw new \RuntimeException('Value not set for field `userId` (expected to be not null)');
		}

		return $this->userId;
	}

	/**
	 * @return bool
	 */
	public function hasUserId(): bool {
		return $this->userId !== null;
	}

	/**
	 * @param string|null $type
	 * @param array<string>|null $fields
	 * @param bool $touched
	 *
	 * @return array{id: int|null, comment: string|null, articleId: int|null, userId: int|null}
	 */
	public function toArray(?string $type = null, ?array $fields = null, bool $touched = false): array {
		/** @var array{id: int|null, comment: string|null, articleId: int|null, userId: int|null} $result */
		$result = $this->_toArrayInternal($type, $fields, $touched);

		return $result;
	}

	/**
	 * @param array{id: int|null, comment: string|null, articleId: int|null, userId: int|null} $data
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
