<?php

use App\Repositories\Eloquent\BaseRepository;
use App\Models\User;
use Illuminate\Foundation\Testing\DatabaseTransactions;

uses(DatabaseTransactions::class);

// Anonymous class to test abstract BaseRepository
class TestRepository extends BaseRepository {
    public function __construct() {
        parent::__construct(new User());
    }
}

test('repository update returns false if record not found', function () {
    $repo = new TestRepository();
    // Use an ID that likely doesn't exist (999999)
    $result = $repo->update(9999999, ['name' => 'New Name']);
    expect($result)->toBeFalse();
});

test('repository delete returns false if record not found', function () {
    $repo = new TestRepository();
    $result = $repo->delete(9999999);
    expect($result)->toBeFalse();
});
