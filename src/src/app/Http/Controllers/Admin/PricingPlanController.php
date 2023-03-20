<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\PricingPlan;
use App\Models\Subscription;

class PricingPlanController extends Controller
{
    public function index()
    {
        $title = "Manage pricing plan";
        $plans = PricingPlan::orderBy('id', 'ASC')->paginate(paginateNumber());
        return view('admin.plan.index', compact('title', 'plans'));
    }

    public function store(Request $request)
    {
        $data = $this->validate($request, [
            'name' => 'required|max:255',
            'amount' => 'required|numeric|min:0',
            'credit' => 'required|integer|min:0',
            'email_credit' => 'required|integer|min:0',
            'whatsapp_credit' => 'required|integer|min:0',
            'duration' => 'required|integer',
            'status' => 'required|in:1,2',
            'recommended_status' => 'nullable|in:1,2'
        ]);
        $data['recommended_status'] = $request->recommended_status ? 1 : 2;
        PricingPlan::create($data);
        $notify[] = ['success', 'Pricing plan has been created'];
        return back()->withNotify($notify);
    }

    public function update(Request $request)
    {
        $data = $this->validate($request, [
            'name' => 'required|max:255',
            'amount' => 'required|numeric|min:0',
            'credit' => 'required|integer|min:0',
            'email_credit' => 'required|integer|min:0',
            'whatsapp_credit' => 'required|integer|min:0',
            'duration' => 'required|integer',
            'status' => 'required|in:1,2',
            'recommended_status' => 'nullable|in:1,2',
        ]);
        $data['recommended_status'] = $request->recommended_status ? 1 : 2;
        $plan = PricingPlan::findOrFail($request->id);
        $plan->update($data);
        $notify[] = ['success', 'Pricing plan has been updated'];
        return back()->withNotify($notify);
    }

    public function delete(Request $request)
    {
        $this->validate($request, [
            'id' => 'required'
        ]);
        Subscription::where('plan_id',$request->id)->delete();
        PricingPlan::where('id',$request->id)->delete();
        $notify[] = ['success', 'Pricing plan has been deleted'];
        return back()->withNotify($notify);
    }
}
