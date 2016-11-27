<?php
namespace App\Controllers\Auth;

use App\Http\Requests\Auth\Campaigns\StoreCampaignRequest;
use App\Http\Requests\Auth\Campaigns\UpdateCampaignRequest;
use App\Socialike\Campaign\Campaign;
use App\Socialike\Campaign\Creator\CreatesCampaign;
use App\Socialike\Campaign\Creator\CreatesCampaignListener;
use App\Socialike\Model\Modeling;
use App\Socialike\Ngo\Ngo;
use App\Socialike\User\User;
use Core\database\factory\Faker;
use Core\flash\Flash;
use Core\Request;
use Core\Response;
use Exception;

class CampaignsController extends AuthController implements CreatesCampaignListener
{
    public function create ()
    {
        Ngo::create(['name' => faker()->company]);

        $ngos = Ngo::all(['id', 'name'])->pluck('id', 'name');

        return $this->view('auth.campaigns.create', compact('ngos'));
    }

    public function store (StoreCampaignRequest $request)
    {
        try
        {
            $surveyor = User::create([
                'email'    => faker()->email,
                'password' => '$2a$06$NTODQCQK7SDwK.F56geB/eCe09Hqw80D8OPHGs4DXkgGAGcKhn0Pi',
            ]);
            $ngo = Ngo::create(['name' => faker()->name]);

            $createsCampaign = new CreatesCampaign();

            $campaignData = Request::all();
            $campaignData['remaining_budget_cents'] = $campaignData['budget_cents'];

            // todo: also get the ngo
            $input = array_merge(['surveyor_id' => $surveyor->id], $campaignData);

            return $createsCampaign->handle($input, $this);
        }
        catch (Exception $e)
        {
            Flash::error($e->getMessage());

            return Response::back();
        }
    }

    public function savedSuccessfully (Modeling $campaign)
    {
        Flash::success('Campaign created.');

        return Response::redirect("/campaigns/$campaign->id/edit");
    }

    public function unableToSave ($errorMessage)
    {
        Flash::error('Unable to create campaign.');

        return Response::back();
    }

    public function edit (Campaign $campaign)
    {
        $ngos = Ngo::all(['id', 'name'])->pluck('id', 'name');

        return $this->view('auth.campaigns.edit', compact('campaign', 'ngos'));
    }

    public function index ()
    {
        $campaigns = Campaign::paginate();

        return $this->view('auth.campaigns.index', compact('campaigns'));
    }

    public function update (Campaign $campaign, UpdateCampaignRequest $request)
    {
        $campaign = Campaign::where(['id' => $campaign->id])->update(Request::only([
            'ngo_id',
            'description',
            'title',
            'budget_cents',
            'payment_cents',
            'start_date',
            'end_date',
        ]));

        Flash::success('Campaign updated.');

        return Response::redirect("/campaigns/$campaign->id/edit");
    }
}