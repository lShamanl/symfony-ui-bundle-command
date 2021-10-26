# Symfony UI Bundle Command
## Описание:
Данный пакет является Симфони-бандлом.

Проблема, которую решает данный пакет:
Снимает с разработчика необходимость писать повторяющийся код в UI-точках входа в приложение(Controllers, CommandBus),
далее Controller.

## Command:
### Sync(Синхронные команды):
Пример:
```php
use App\Path\To\UseCase as UseCase;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Nelmio\ApiDocBundle\Annotation\Model;
use OpenApi\Annotations as OA;
use SymfonyBundle\UIBundle\Command\Core\CQRS\Command\Sync\Context as CommandSyncContext;
use SymfonyBundle\UIBundle\Command\Core\CQRS\Command\Sync\Processor as CommandSyncProcessor;
use SymfonyBundle\UIBundle\Foundation\Core\Contract\ApiFormatter;
use SymfonyBundle\UIBundle\Foundation\Core\Dto\OutputFormat;

class Controller {
    /**
     * @Route(".{_format}", methods={"POST"}, name=".create", defaults={"_format"="json"})
     * @OA\Post(
     *     @OA\RequestBody(
     *         @OA\MediaType(
     *             mediaType="application/json",
     *             @OA\Schema(
     *                 ref=@Model(type=UseCase\Create\Contract::class)
     *             )
     *         )
     *     )
     * )
     * @OA\Response(
     *     response=200,
     *     description="Create User",
     *     @OA\JsonContent(
     *          allOf={
     *              @OA\Schema(ref=@Model(type=ApiFormatter::class)),
     *              @OA\Schema(type="object",
     *                  @OA\Property(
     *                      property="data",
     *                      type="object",
     *                      @OA\Property(
     *                          property="entities",
     *                          ref=@Model(type=UseCase\CommonOutputContract::class)
     *                      )
     *                  ),
     *                  @OA\Property(
     *                      property="status",
     *                      example="200"
     *                 )
     *              )
     *          }
     *      )
     * )
     */
    public function create(
        CommandSyncProcessor $processor,
        OutputFormat $outputFormat,
        UseCase\Create\Contract $contract,
        UseCase\Create\Handler $handler
    ): Response {
        $command = new UseCase\Create\Command();
        $command->mapContract($contract);

        $context = new CommandSyncContext(
            handler: $handler,
            command: $command,
            outputFormat: $outputFormat->getFormat(),
        );

        $processor->process($context);
        return $processor->makeResponse();
    }
}
```
### Async(Асинхронные команды):
Пример:
```php
use App\Path\To\Entity;
use App\Path\To\UseCase as UseCase;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Nelmio\ApiDocBundle\Annotation\Model;
use OpenApi\Annotations as OA;
use SymfonyBundle\UIBundle\Command\Core\CQRS\Command\Async\Context as CommandAsyncContext;
use SymfonyBundle\UIBundle\Command\Core\CQRS\Command\Async\Processor as CommandAsyncProcessor;
use SymfonyBundle\UIBundle\Foundation\Core\Contract\ApiFormatter;
use SymfonyBundle\UIBundle\Foundation\Core\Dto\OutputFormat;

class Controller {
    /**
     * @Route(".{_format}", methods={"POST"}, name=".create", defaults={"_format"="json"})
     * @OA\Post(
     *     @OA\RequestBody(
     *         @OA\MediaType(
     *             mediaType="application/json",
     *             @OA\Schema(
     *                 ref=@Model(type=UseCase\Create\Contract::class)
     *             )
     *         )
     *     )
     * )
     * @OA\Response(
     *     response=200,
     *     description="Create Message",
     *     @OA\JsonContent(
     *          allOf={
     *              @OA\Schema(ref=@Model(type=ApiFormatter::class)),
     *              @OA\Schema(type="object",
     *                  @OA\Property(
     *                      property="ok",
     *                      example=true
     *                 )
     *                  @OA\Property(
     *                      property="status",
     *                      example="200"
     *                 )
     *              )
     *          }
     *      )
     * )
     */
    public function create(
        CommandSyncProcessor $processor,
        OutputFormat $outputFormat,
        UseCase\Create\Contract $contract,
        UseCase\Create\Handler $handler
    ): Response {
        $command = new UseCase\Create\Command();
        $command->mapContract($contract);

        $context = new CommandAsyncContext(
            command: $command,
            outputFormat: $outputFormat->getFormat(),
        );

        $processor->process($context);
        return $processor->makeResponse();
    }
```