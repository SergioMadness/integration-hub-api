<?php namespace professionalweb\IntegrationHub\IntegrationHub\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Validation\Validator;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;
use professionalweb\IntegrationHub\IntegrationHubCommon\Jobs\NewRequest;
use professionalweb\IntegrationHub\IntegrationHubDB\Models\Request as RequestModel;
use professionalweb\IntegrationHub\IntegrationHubCommon\Traits\UseRequestRepository;
use professionalweb\IntegrationHub\IntegrationHubCommon\Interfaces\Repositories\RequestRepository;

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
     * Get event list
     *
     * @param Request $request
     *
     * @return Response
     */
    public function index(Request $request): Response
    {
        $cnt = $this->getRequestRepository()->count();
        $limit = $this->getLimit($request);
        $offset = max($request->get('offset', 0), 0);

        $data = $this->getRequestRepository()->get([], [], $limit, $offset);

        return $this->listResponse($data, $cnt, $limit, $offset);
    }

    /**
     * Get model
     *
     * @param string $id
     *
     * @return Response
     */
    public function view(string $id): Response
    {
        return $this->response(
            $this->getModel($id)
        );
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

        /** @var RequestModel $model */
        $model = $this->getRequestRepository()->create([
            'application_id' => $request->attributes->get('application')->id,
            'body'           => [
                'original' => $data,
            ],
        ]);
        $this->getRequestRepository()->save($model);

        $this->sendEvent($model);

        return $this->response($model);
    }

    /**
     * Send request
     *
     * @param RequestModel $model
     */
    protected function sendEvent(RequestModel $model): void
    {
        $this->dispatch(
            (new NewRequest($model))
                ->onConnection(config('integration-hub.new-event-connection'))
                ->onQueue(config('integration-hub.new-event-queue'))
        );
    }

    /**
     * Delete event
     *
     * @param string $id
     *
     * @return Response
     */
    public function destroy(string $id): Response
    {
        $this->getRequestRepository()->remove(
            $this->getRequestRepository()->model($id)
        );

        return $this->response('', [], self::STATUS_NO_CONTENT);
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

    /**
     * Get model by id
     *
     * @param string $id
     *
     * @return RequestModel
     */
    protected function getModel(string $id): RequestModel
    {
        $model = $this->getRequestRepository()->model($id);
        if ($model === null) {
            throw new NotFoundHttpException(trans('errors.not-found'));
        }

        return $model;
    }
}