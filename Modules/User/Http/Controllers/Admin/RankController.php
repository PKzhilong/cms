<?php


namespace Modules\User\Http\Controllers\Admin;


use App\Http\Controllers\MyController;
use Illuminate\Http\Request;
use Modules\User\Http\Requests\UserRankRequest;
use Modules\User\Models\UserRank;

class RankController extends MyController
{
    public function index(Request $request)
    {
        if ($request->ajax() && $request->wantsJson()) {
            $point = UserRank::orderBy('id', 'desc')
                ->paginate($this->request('limit', 'intval'))->toArray();

            return $this->jsonSuc($point);
        }
        return $this->view('admin.rank.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return $this->view('admin.rank.create');
    }

    /**
     * Store a newly created resource in storage.
     * @param UserRankRequest $request
     * @param UserRank $rank
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(UserRankRequest $request, UserRank $rank)
    {
        $data = $request->validated();
        $result = $rank->store($data);

        return $this->result($result);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit()
    {
        $rank = UserRank::find($this->request('id', 'intval'));
        return $this->view('admin.rank.edit', compact('rank'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UserRankRequest $request, UserRank $rank)
    {
        if ($id = $this->request('id', 'intval')) {

            $data = $request->validated();
            $data['id'] = $id;

            $result = $rank->up($data);

            return $this->result($result);
        }

        return $this->result(false);

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy()
    {
        $result = UserRank::destroy($this->request('id', 'intval'));
        return $this->result($result);
    }
}
