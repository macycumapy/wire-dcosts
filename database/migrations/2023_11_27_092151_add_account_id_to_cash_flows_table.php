<?php

declare(strict_types=1);

use App\Models\CashFlow;
use App\Models\User;
use App\Services\DefaultDataFillers\AccountFiller;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class () extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('cash_flows', function (Blueprint $table) {
            $table->foreignId('account_id')->after('user_id')->nullable()->constrained();
        });

        User::query()->with('cashFlows')->chunk(500, function ($users) {
            /** @var User $user */
            foreach ($users as $user) {
                $account = app(AccountFiller::class)->fill($user, CashFlow::getBalance($user));
                $user->cashFlows()->withTrashed()->update(['account_id' => $account->id]);
            }
        });

        Schema::table('cash_flows', function (Blueprint $table) {
            $table->foreignId('account_id')->nullable(false)->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('cash_flows', function (Blueprint $table) {
            $table->dropConstrainedForeignId('account_id');
        });
    }
};
