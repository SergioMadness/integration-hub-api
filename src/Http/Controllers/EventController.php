<?php namespace professionalweb\IntegrationHub\IntegrationHub\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Validation\Validator;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;
use professionalweb\IntegrationHub\IntegrationHubCommon\Jobs\NewRequest;
use professionalweb\IntegrationHub\IntegrationHubDB\Traits\UseRequestRepository;
use professionalweb\IntegrationHub\IntegrationHubDB\Interfaces\Repositories\RequestRepository;

/**
 * Controller to work with events/requests
 * @package professionalweb\IntegrationHub\IntegrationHub\Http\Controllers
 */
class EventController extends Controller
{
    use UseRequestRepository, DispatchesJobs;

    public function __construct(RequestRepository $repository)
    {
        $this->setRequestRepository($repository);
    }

    /**
     * Store event
     *
     * @param Request $request
     *
     * @return Response
     */
    public function store(Request $request): Response
    {
        $data = $request->all();
        $validator = $this->getValidator($data);
        if ($validator->fails()) {
            throw new BadRequestHttpException($validator->errors()->first());
        }

        /** @var \professionalweb\IntegrationHub\IntegrationHubDB\Models\Request $model */
        $model = $this->getRequestRepository()->create([
            'application_id' => $request->attributes->get('application')->id,
            'body'           => $data,
        ]);
        $this->getRequestRepository()->save($model);

        $this->dispatch(
            (new NewRequest($model))
                ->onConnection(config('integration-hub.new-event-connection', 'default'))
                ->onQueue(config('integration-hub.new-event-queue', 'default'))
        );

        return $this->response($model);
    }

    /**
     * Create validator
     *
     * @param array $data
     *
     * @return Validator
     */
    protected function getValidator(array $data): Validator
    {
        $validator = \Validator::make($data, [
//            'data' => 'required|array',
        ]);

        return $validator;
    }
}