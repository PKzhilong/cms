<?php


namespace Modules\User\Service;


use App\Service\MyService;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Modules\User\Models\User;
use Modules\User\Models\UserBalance;
use Modules\User\Models\UserPoint;
use Modules\User\Models\UserRank;

class UserService extends MyService
{
    /**
     * 会员余额变动
     * @param float $balance
     * @param int $id
     * @param $desc
     * @return bool
     */
    public function balance(float $balance, int $id, $desc = ''): bool
    {
        DB::beginTransaction();
        try {
            $user = $this->user($id);
            $log = (new UserBalance())->store([
                'user_id' => $id,
                'before' => $user['balance'],
                'balance' => $balance,
                'after' => ($balance + $user['balance']),
                'description' => $desc,
            ]);

            $user->balance = ($balance + $user['balance']);
            $result = $user->save();

            if ($result !== false && $log !== false) {
                Db::commit();
                return true;
            } else {
                Db::rollBack();
                return false;
            }

        } catch (\Exception $e) {
            Db::rollBack();
            return false;
        }

    }

    /**
     * 会员积分变动
     * @param float $point
     * @param int $id
     * @param $desc
     * @return bool
     */
    public function point(float $point, int $id, $desc = ''): bool
    {
        DB::beginTransaction();

        try {

            $user = $this->user($id);
            $log = (new UserPoint())->store([
                'user_id' => $id,
                'before' => $user['point'],
                'point' => $point,
                'after' => ($point + $user['point']),
                'description' => $desc,
            ]);

            $user->point = ($point + $user['point']);
            $result = $user->save();

            if ($result !== false && $log !== false) {
                Db::commit();
                return true;
            } else {
                Db::rollBack();
                return false;
            }
        } catch (\Exception $e) {
            Db::rollBack();
            return false;
        }
    }

    /**
     * 获取单个用户
     * @param $param
     * @return mixed
     */
    public function user($param)
    {
        if (is_numeric($param)) {
            return User::find($param);
        }

        if (is_string($param)) {
            return User::where('name', $param)->first();
        }

        if (is_array($param)) {
            return User::where([$param])->first();
        }
    }

    /**
     * @param $user
     * @return mixed
     */
    public function userFields($user)
    {
        // 会员等级
        $user->rank_name = $user->rank > 0 ? UserRank::find($user->rank)->name : '' ;

        return $user;
    }

    /**
     * 生成会员
     * @param $name
     * @param $password
     * @param $mobile
     * @return false|mixed
     */
    public function generateUser($name, $password, $mobile = '')
    {
        $user = $this->user($name);

        if (!$user) {

            $user = new User();
            $user->store([
                'name' => $name,
                'password' => Hash::make($password),
                'mobile' => $mobile ?: mb_substr($name, 0, 11),
            ]);

            return $user->id;

        }

        return false;
    }

    /**
     * 返回所有会员等级
     * @return mixed
     */
    public function ranks()
    {
        return UserRank::orderBy("number", "asc")->get();
    }
}
