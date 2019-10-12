<?php

namespace App\Nova\Lenses;

use Carbon\Carbon;
use Laravel\Nova\Fields\ID;
use Illuminate\Http\Request;
use Laravel\Nova\Fields\Text;
use Laravel\Nova\Lenses\Lens;
use Davidpiesse\NovaToggle\Toggle;
use Laravel\Nova\Http\Requests\LensRequest;
use App\Nova\Actions\ExportCommunityActivity;
use Saumini\EllipsisTextarea\EllipsisTextarea;
use Maatwebsite\LaravelNovaExcel\Actions\DownloadExcel;

class CommunityActivity extends Lens
{
    /**
     * Get the query builder / paginator for the lens.
     *
     * @param  \Laravel\Nova\Http\Requests\LensRequest  $request
     * @param  \Illuminate\Database\Eloquent\Builder  $query
     * @return mixed
     */
    public $name = 'Community Activity';

    protected static function columns()
    {
        return [
            'osusr_mlv_community.COMMUNITYID',
            'osusr_mlv_community.FRIENDLYNAME',
            'osusr_mlv_community.COUNTY',
            'osusr_mlv_community.STATE',
            'b.onboarding_status',
            'b.rfp_status',
            'b.key_policy_agreement',
            'r.name',
            's.rental_status',
            's.vacant_status',
            'c.notice_required',
        ];
    }

    public static function query(LensRequest $request, $query)
    {
        $resourceTable = 'osusr_mlv_community';
        $orderBy = $request->get('orderBy');
        $query->getQuery()->orders = null;

        return $request->withOrdering($request->withFilters(
            $query->select(self::columns())
            ->leftJoin('cm_community_rm as p', "{$resourceTable}.COMMUNITYID", '=', 'p.community_id')
            ->leftJoin('cm_relationship_managers as r', 'p.relationship_manager_id', '=', 'r.id')
            ->leftJoin('osusr_tvl_crm as f', "{$resourceTable}.COMMUNITYID", '=', 'f.COMMUNITYID')
            ->leftJoin('cm_rental_vacant_sales_statuses as s', "{$resourceTable}.COMMUNITYID", '=', 's.community_id')
            ->leftJoin('cm_community_sales_configurations as b', "{$resourceTable}.COMMUNITYID", '=', 'b.community_id')
            ->leftJoin('cm_contracts as c', "{$resourceTable}.COMMUNITYID", '=', 'c.community_id')
            ->whereIn('f.SALESSTATUSID', [5, 14])
            ->orWhereIn('s.rental_status', [5, 14])
            ->orWhereIn('s.vacant_status', [5, 14])
        ));
    }

    /**
     * Get the fields available to the lens.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function fields(Request $request)
    {
        return [
            ID::make('ID', 'COMMUNITYID')->sortable(),
            EllipsisTextarea::make('Community', 'FRIENDLYNAME')->sortable()->displayLength(20),
            Text::make('County', 'COUNTY')->sortable(),
            Text::make('State', 'STATE')->sortable(),
            EllipsisTextarea::make('RM', 'name')->sortable()->displayLength(10),
            Text::make('Rental', 'rental_status')->sortable()->resolveUsing(function ($statusId) {
                switch ($statusId) {
                    case 1:
                        return 0;
                    case 5:
                        return 5;
                    case 6:
                        return 4;
                    case 7:
                        return 1;
                    case 10:
                        return 0;
                    case 11:
                        return 2;
                    case 12:
                        return 3;
                    case 13:
                        return 1;
                    case 14:
                        return 6;
                    default:
                        return 0;
                }
            }),
            Text::make('Vacant', 'vacant_status')->sortable()->resolveUsing(function ($statusId) {
                switch ($statusId) {
                    case 1:
                        return 0;
                    case 5:
                        return 5;
                    case 6:
                        return 4;
                    case 7:
                        return 1;
                    case 10:
                        return 0;
                    case 11:
                        return 2;
                    case 12:
                        return 3;
                    case 13:
                        return 1;
                    case 14:
                        return 6;
                    default:
                        return 0;
                }
            }),
            Text::make('Foreclosure', 'SALESSTATUSID')->sortable()->resolveUsing(function ($statusId) {
                switch ($statusId) {
                    case 1:
                        return 0;
                    case 5:
                        return 5;
                    case 6:
                        return 4;
                    case 7:
                        return 1;
                    case 10:
                        return 0;
                    case 11:
                        return 2;
                    case 12:
                        return 3;
                    case 13:
                        return 1;
                    case 14:
                        return 6;
                    default:
                        return 0;
                }
            }),
            Text::make('Onboarding Status', 'onboarding_status')->resolveUsing(function ($status) {
                switch ($status) {
                    case 1:
                        return 'Started';
                    case 2:
                        return 'Selection Confirmed';
                    case 3:
                        return 'Contract Executed';
                    case 4:
                        return 'Live for Registrations';
                    case 5:
                        return 'OTRs Notified';
                    case 6:
                        return 'Complete';
                    default:
                        return 'Unknown';
                }
            })->sortable(),
            Toggle::make('RFP Activity', 'rfp_status')->sortable(),
            Toggle::make('Key Policy', 'key_policy_agreement')->sortable(),
            Toggle::make('Notice of Change', 'notice_required'),
        ];
    }

    /**
     * Get the filters available for the lens.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function filters(Request $request)
    {
        return [];
    }

    /**
     * Get the actions available on the lens.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function actions(Request $request)
    {
        return [
            (new ExportCommunityActivity())
                ->withFilename('Community_Activity-'.Carbon::now()->format('YmdHs').'.xlsx')
                ->withHeadings('Id'),

        ];
    }

    /**
     * Get the URI key for the lens.
     *
     * @return string
     */
    public function uriKey()
    {
        return 'community-activity';
    }
}
