<?php namespace professionalweb\IntegrationHub\IntegrationHub\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Contracts\Validation\Validator as IValidator;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;
use professionalweb\IntegrationHub\IntegrationHubDB\Interfaces\Model;
use professionalweb\IntegrationHub\IntegrationHub\Traits\UseUserRepository;
use professionalweb\IntegrationHub\IntegrationHub\Interfaces\Repositories\UserRepository;

/**
 * Controller to work with users
 * @package professionalweb\IntegrationHub\IntegrationHub\Http\Controllers
 */
class UserController extends Controller
{
    use UseUserRepository;

    public function __construct(UserRepository $userRepository)
    {
        $this->setUserRepository($userRepository);
    }

    /**
     * Get user list
     *
     * @param Request $request
     *
     * @return Response
     */
    public function index(Request $request): Response
    {
        $limit = $this->getLimit($request);
        $offset = max(0, $request->get('offset', 0));

        $data = $this->getUserRepository()->get([], [], $limit, $offset);

        return $this->response($data);
    }

    /**
     * Save user
     *
     * @param Request $request
     * @param null    $id
     *
     * @return Response
     * @throws \Exception
     */
    public function store(Request $request, $id = null): Response
    {
        $data = $request->all();

        if ($id !== null) {
            $model = $this->getModel($id);
        } else {
            $model = $this->getUserRepository()->create();
        }

        $validator = $this->getValidator($data);
        if ($validator->fails()) {
            throw new BadRequestHttpException($validator->errors()->first());
        }

        if (!$this->getUserRepository()->fill($model, $data)->save()) {
            throw new \Exception('Невозможно сохранить пользователя');
        }

        return $this->response($model, [], $id === null ? self::STATUS_CREATED : self::STATUS_OK);
    }

    /**
     * Get user by id
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
     * Remove user
     *
     * @param string $id
     *
     * @return Response
     */
    public function destroy(string $id): Response
    {
        $this->getModel($id)->delete();

        return $this->response(null, [], self::STATUS_NO_CONTENT);
    }

    /**
     * Create validator
     *
     * @param array $data
     *
     * @return IValidator
     */
    protected function getValidator(array $data): IValidator
    {
        $validator = Validator::make($data, [
            'login'    => 'required',
            'password' => 'required',
        ]);

        return $validator;
    }

    /**
     * Get model by id
     *
     * @param int|string $id
     *
     * @return Model
     * @throws NotFoundHttpException
     */
    protected function getModel($id): Model
    {
        $model = $this->getUserRepository()->model($id);

        if ($model === null) {
            throw new NotFoundHttpException();
        }

        return $model;
    }
}