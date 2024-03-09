<?php

namespace Domain\Models;

class UserPaginatedListDTO implements \JsonSerializable
{
    /**
     * @param int $page
     * @param int $perPage
     * @param int $total
     * @param int $totalPages
     * @param array<UserDTO> $list
     */
    public function __construct(
        public readonly int   $page,
        public readonly int   $perPage,
        public readonly int   $total,
        public readonly int   $totalPages,
        public readonly array $list
    )
    {
    }

    /**
     * @return array<string, mixed>
     */
    public function jsonSerialize(): array
    {
        $list = [];
        foreach ($this->list as $userDTO) {
            $list[] = $userDTO->jsonSerialize();
        }
        return [
            'page' => $this->page,
            'per_page' => $this->perPage,
            'total' => $this->total,
            'total_pages' => $this->totalPages,
            'list' => $list,
        ];
    }
}