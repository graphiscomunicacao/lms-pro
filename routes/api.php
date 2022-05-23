<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\JobController;
use App\Http\Controllers\Api\RoleController;
use App\Http\Controllers\Api\TeamController;
use App\Http\Controllers\Api\MenuController;
use App\Http\Controllers\Api\QuizController;
use App\Http\Controllers\Api\UserController;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\GroupController;
use App\Http\Controllers\Api\CategoryController;
use App\Http\Controllers\Api\JobUsersController;
use App\Http\Controllers\Api\JobMenusController;
use App\Http\Controllers\Api\MenuJobsController;
use App\Http\Controllers\Api\RoleUsersController;
use App\Http\Controllers\Api\TeamUsersController;
use App\Http\Controllers\Api\TeamMenusController;
use App\Http\Controllers\Api\MenuTeamsController;
use App\Http\Controllers\Api\QuizMenusController;
use App\Http\Controllers\Api\UserUsersController;
use App\Http\Controllers\Api\UserTeamsController;
use App\Http\Controllers\Api\GroupUsersController;
use App\Http\Controllers\Api\SupportLinkController;
use App\Http\Controllers\Api\CertificateController;
use App\Http\Controllers\Api\MenuQuizzesController;
use App\Http\Controllers\Api\LearningPathController;
use App\Http\Controllers\Api\QuizCategoriesController;
use App\Http\Controllers\Api\CategoryQuizzesController;
use App\Http\Controllers\Api\QuizQuizResultsController;
use App\Http\Controllers\Api\UserQuizResultsController;
use App\Http\Controllers\Api\JobLearningPathsController;
use App\Http\Controllers\Api\SupportLinkMenusController;
use App\Http\Controllers\Api\LearningArtifactController;
use App\Http\Controllers\Api\MenuSupportLinksController;
use App\Http\Controllers\Api\LearningPathJobsController;
use App\Http\Controllers\Api\UserAchievementsController;
use App\Http\Controllers\Api\TeamLearningPathsController;
use App\Http\Controllers\Api\LearningPathTeamsController;
use App\Http\Controllers\Api\LearningPathUsersController;
use App\Http\Controllers\Api\QuizLearningPathsController;
use App\Http\Controllers\Api\UserLearningPathsController;
use App\Http\Controllers\Api\LearningPathQuizzesController;
use App\Http\Controllers\Api\CategorySupportLinksController;
use App\Http\Controllers\Api\JobLearningArtifactsController;
use App\Http\Controllers\Api\LearningArtifactJobsController;
use App\Http\Controllers\Api\UserObjectiveAnswersController;
use App\Http\Controllers\Api\CategoryLearningPathsController;
use App\Http\Controllers\Api\JobLearningPathGroupsController;
use App\Http\Controllers\Api\SupportLinkCategoriesController;
use App\Http\Controllers\Api\TeamLearningArtifactsController;
use App\Http\Controllers\Api\LearningArtifactMenusController;
use App\Http\Controllers\Api\LearningArtifactTeamsController;
use App\Http\Controllers\Api\MenuLearningArtifactsController;
use App\Http\Controllers\Api\UserExperienceDetailsController;
use App\Http\Controllers\Api\TeamLearningPathGroupsController;
use App\Http\Controllers\Api\LearningPathCategoriesController;
use App\Http\Controllers\Api\QuizObjectiveQuestionsController;
use App\Http\Controllers\Api\CertificateLearningPathsController;
use App\Http\Controllers\Api\CategoryLearningArtifactsController;
use App\Http\Controllers\Api\CategoryObjectiveQuestionsController;
use App\Http\Controllers\Api\LearningArtifactCategoriesController;
use App\Http\Controllers\Api\UserLearningPathGroupResultsController;
use App\Http\Controllers\Api\LearningArtifactLearningPathsController;
use App\Http\Controllers\Api\LearningPathLearningArtifactsController;
use App\Http\Controllers\Api\LearningPathLearningPathGroupsController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::post('/login', [AuthController::class, 'login'])->name('api.login');

Route::middleware('auth:sanctum')
    ->get('/user', function (Request $request) {
        return $request->user();
    })
    ->name('api.user');

Route::name('api.')
    ->middleware('auth:sanctum')
    ->group(function () {
        Route::apiResource('categories', CategoryController::class);

        // Category Learning Artifacts
        Route::get('/categories/{category}/learning-artifacts', [
            CategoryLearningArtifactsController::class,
            'index',
        ])->name('categories.learning-artifacts.index');
        Route::post(
            '/categories/{category}/learning-artifacts/{learningArtifact}',
            [CategoryLearningArtifactsController::class, 'store']
        )->name('categories.learning-artifacts.store');
        Route::delete(
            '/categories/{category}/learning-artifacts/{learningArtifact}',
            [CategoryLearningArtifactsController::class, 'destroy']
        )->name('categories.learning-artifacts.destroy');

        // Category Support Links
        Route::get('/categories/{category}/support-links', [
            CategorySupportLinksController::class,
            'index',
        ])->name('categories.support-links.index');
        Route::post('/categories/{category}/support-links/{supportLink}', [
            CategorySupportLinksController::class,
            'store',
        ])->name('categories.support-links.store');
        Route::delete('/categories/{category}/support-links/{supportLink}', [
            CategorySupportLinksController::class,
            'destroy',
        ])->name('categories.support-links.destroy');

        // Category Objective Questions
        Route::get('/categories/{category}/objective-questions', [
            CategoryObjectiveQuestionsController::class,
            'index',
        ])->name('categories.objective-questions.index');
        Route::post(
            '/categories/{category}/objective-questions/{objectiveQuestion}',
            [CategoryObjectiveQuestionsController::class, 'store']
        )->name('categories.objective-questions.store');
        Route::delete(
            '/categories/{category}/objective-questions/{objectiveQuestion}',
            [CategoryObjectiveQuestionsController::class, 'destroy']
        )->name('categories.objective-questions.destroy');

        // Category Quizzes
        Route::get('/categories/{category}/quizzes', [
            CategoryQuizzesController::class,
            'index',
        ])->name('categories.quizzes.index');
        Route::post('/categories/{category}/quizzes/{quiz}', [
            CategoryQuizzesController::class,
            'store',
        ])->name('categories.quizzes.store');
        Route::delete('/categories/{category}/quizzes/{quiz}', [
            CategoryQuizzesController::class,
            'destroy',
        ])->name('categories.quizzes.destroy');

        // Category Learning Paths
        Route::get('/categories/{category}/learning-paths', [
            CategoryLearningPathsController::class,
            'index',
        ])->name('categories.learning-paths.index');
        Route::post('/categories/{category}/learning-paths/{learningPath}', [
            CategoryLearningPathsController::class,
            'store',
        ])->name('categories.learning-paths.store');
        Route::delete('/categories/{category}/learning-paths/{learningPath}', [
            CategoryLearningPathsController::class,
            'destroy',
        ])->name('categories.learning-paths.destroy');

        Route::apiResource('groups', GroupController::class);

        // Group Users
        Route::get('/groups/{group}/users', [
            GroupUsersController::class,
            'index',
        ])->name('groups.users.index');
        Route::post('/groups/{group}/users', [
            GroupUsersController::class,
            'store',
        ])->name('groups.users.store');

        Route::apiResource('jobs', JobController::class);

        // Job Users
        Route::get('/jobs/{job}/users', [
            JobUsersController::class,
            'index',
        ])->name('jobs.users.index');
        Route::post('/jobs/{job}/users', [
            JobUsersController::class,
            'store',
        ])->name('jobs.users.store');

        // Job Learning Paths
        Route::get('/jobs/{job}/learning-paths', [
            JobLearningPathsController::class,
            'index',
        ])->name('jobs.learning-paths.index');
        Route::post('/jobs/{job}/learning-paths/{learningPath}', [
            JobLearningPathsController::class,
            'store',
        ])->name('jobs.learning-paths.store');
        Route::delete('/jobs/{job}/learning-paths/{learningPath}', [
            JobLearningPathsController::class,
            'destroy',
        ])->name('jobs.learning-paths.destroy');

        // Job Menus
        Route::get('/jobs/{job}/menus', [
            JobMenusController::class,
            'index',
        ])->name('jobs.menus.index');
        Route::post('/jobs/{job}/menus/{menu}', [
            JobMenusController::class,
            'store',
        ])->name('jobs.menus.store');
        Route::delete('/jobs/{job}/menus/{menu}', [
            JobMenusController::class,
            'destroy',
        ])->name('jobs.menus.destroy');

        // Job Learning Artifacts
        Route::get('/jobs/{job}/learning-artifacts', [
            JobLearningArtifactsController::class,
            'index',
        ])->name('jobs.learning-artifacts.index');
        Route::post('/jobs/{job}/learning-artifacts/{learningArtifact}', [
            JobLearningArtifactsController::class,
            'store',
        ])->name('jobs.learning-artifacts.store');
        Route::delete('/jobs/{job}/learning-artifacts/{learningArtifact}', [
            JobLearningArtifactsController::class,
            'destroy',
        ])->name('jobs.learning-artifacts.destroy');

        // Job Learning Path Groups
        Route::get('/jobs/{job}/learning-path-groups', [
            JobLearningPathGroupsController::class,
            'index',
        ])->name('jobs.learning-path-groups.index');
        Route::post('/jobs/{job}/learning-path-groups/{learningPathGroup}', [
            JobLearningPathGroupsController::class,
            'store',
        ])->name('jobs.learning-path-groups.store');
        Route::delete('/jobs/{job}/learning-path-groups/{learningPathGroup}', [
            JobLearningPathGroupsController::class,
            'destroy',
        ])->name('jobs.learning-path-groups.destroy');

        Route::apiResource('roles', RoleController::class);

        // Role Users
        Route::get('/roles/{role}/users', [
            RoleUsersController::class,
            'index',
        ])->name('roles.users.index');
        Route::post('/roles/{role}/users', [
            RoleUsersController::class,
            'store',
        ])->name('roles.users.store');

        Route::apiResource('support-links', SupportLinkController::class);

        // SupportLink Categories
        Route::get('/support-links/{supportLink}/categories', [
            SupportLinkCategoriesController::class,
            'index',
        ])->name('support-links.categories.index');
        Route::post('/support-links/{supportLink}/categories/{category}', [
            SupportLinkCategoriesController::class,
            'store',
        ])->name('support-links.categories.store');
        Route::delete('/support-links/{supportLink}/categories/{category}', [
            SupportLinkCategoriesController::class,
            'destroy',
        ])->name('support-links.categories.destroy');

        // SupportLink Menus
        Route::get('/support-links/{supportLink}/menus', [
            SupportLinkMenusController::class,
            'index',
        ])->name('support-links.menus.index');
        Route::post('/support-links/{supportLink}/menus/{menu}', [
            SupportLinkMenusController::class,
            'store',
        ])->name('support-links.menus.store');
        Route::delete('/support-links/{supportLink}/menus/{menu}', [
            SupportLinkMenusController::class,
            'destroy',
        ])->name('support-links.menus.destroy');

        Route::apiResource('teams', TeamController::class);

        // Team Users
        Route::get('/teams/{team}/users', [
            TeamUsersController::class,
            'index',
        ])->name('teams.users.index');
        Route::post('/teams/{team}/users/{user}', [
            TeamUsersController::class,
            'store',
        ])->name('teams.users.store');
        Route::delete('/teams/{team}/users/{user}', [
            TeamUsersController::class,
            'destroy',
        ])->name('teams.users.destroy');

        // Team Learning Paths
        Route::get('/teams/{team}/learning-paths', [
            TeamLearningPathsController::class,
            'index',
        ])->name('teams.learning-paths.index');
        Route::post('/teams/{team}/learning-paths/{learningPath}', [
            TeamLearningPathsController::class,
            'store',
        ])->name('teams.learning-paths.store');
        Route::delete('/teams/{team}/learning-paths/{learningPath}', [
            TeamLearningPathsController::class,
            'destroy',
        ])->name('teams.learning-paths.destroy');

        // Team Menus
        Route::get('/teams/{team}/menus', [
            TeamMenusController::class,
            'index',
        ])->name('teams.menus.index');
        Route::post('/teams/{team}/menus/{menu}', [
            TeamMenusController::class,
            'store',
        ])->name('teams.menus.store');
        Route::delete('/teams/{team}/menus/{menu}', [
            TeamMenusController::class,
            'destroy',
        ])->name('teams.menus.destroy');

        // Team Learning Artifacts
        Route::get('/teams/{team}/learning-artifacts', [
            TeamLearningArtifactsController::class,
            'index',
        ])->name('teams.learning-artifacts.index');
        Route::post('/teams/{team}/learning-artifacts/{learningArtifact}', [
            TeamLearningArtifactsController::class,
            'store',
        ])->name('teams.learning-artifacts.store');
        Route::delete('/teams/{team}/learning-artifacts/{learningArtifact}', [
            TeamLearningArtifactsController::class,
            'destroy',
        ])->name('teams.learning-artifacts.destroy');

        // Team Learning Path Groups
        Route::get('/teams/{team}/learning-path-groups', [
            TeamLearningPathGroupsController::class,
            'index',
        ])->name('teams.learning-path-groups.index');
        Route::post('/teams/{team}/learning-path-groups/{learningPathGroup}', [
            TeamLearningPathGroupsController::class,
            'store',
        ])->name('teams.learning-path-groups.store');
        Route::delete(
            '/teams/{team}/learning-path-groups/{learningPathGroup}',
            [TeamLearningPathGroupsController::class, 'destroy']
        )->name('teams.learning-path-groups.destroy');

        Route::apiResource('certificates', CertificateController::class);

        // Certificate Learning Paths
        Route::get('/certificates/{certificate}/learning-paths', [
            CertificateLearningPathsController::class,
            'index',
        ])->name('certificates.learning-paths.index');
        Route::post('/certificates/{certificate}/learning-paths', [
            CertificateLearningPathsController::class,
            'store',
        ])->name('certificates.learning-paths.store');

        Route::apiResource(
            'learning-artifacts',
            LearningArtifactController::class
        );

        // LearningArtifact Categories
        Route::get('/learning-artifacts/{learningArtifact}/categories', [
            LearningArtifactCategoriesController::class,
            'index',
        ])->name('learning-artifacts.categories.index');
        Route::post(
            '/learning-artifacts/{learningArtifact}/categories/{category}',
            [LearningArtifactCategoriesController::class, 'store']
        )->name('learning-artifacts.categories.store');
        Route::delete(
            '/learning-artifacts/{learningArtifact}/categories/{category}',
            [LearningArtifactCategoriesController::class, 'destroy']
        )->name('learning-artifacts.categories.destroy');

        // LearningArtifact Learning Paths
        Route::get('/learning-artifacts/{learningArtifact}/learning-paths', [
            LearningArtifactLearningPathsController::class,
            'index',
        ])->name('learning-artifacts.learning-paths.index');
        Route::post(
            '/learning-artifacts/{learningArtifact}/learning-paths/{learningPath}',
            [LearningArtifactLearningPathsController::class, 'store']
        )->name('learning-artifacts.learning-paths.store');
        Route::delete(
            '/learning-artifacts/{learningArtifact}/learning-paths/{learningPath}',
            [LearningArtifactLearningPathsController::class, 'destroy']
        )->name('learning-artifacts.learning-paths.destroy');

        // LearningArtifact Menus
        Route::get('/learning-artifacts/{learningArtifact}/menus', [
            LearningArtifactMenusController::class,
            'index',
        ])->name('learning-artifacts.menus.index');
        Route::post('/learning-artifacts/{learningArtifact}/menus/{menu}', [
            LearningArtifactMenusController::class,
            'store',
        ])->name('learning-artifacts.menus.store');
        Route::delete('/learning-artifacts/{learningArtifact}/menus/{menu}', [
            LearningArtifactMenusController::class,
            'destroy',
        ])->name('learning-artifacts.menus.destroy');

        // LearningArtifact Teams
        Route::get('/learning-artifacts/{learningArtifact}/teams', [
            LearningArtifactTeamsController::class,
            'index',
        ])->name('learning-artifacts.teams.index');
        Route::post('/learning-artifacts/{learningArtifact}/teams/{team}', [
            LearningArtifactTeamsController::class,
            'store',
        ])->name('learning-artifacts.teams.store');
        Route::delete('/learning-artifacts/{learningArtifact}/teams/{team}', [
            LearningArtifactTeamsController::class,
            'destroy',
        ])->name('learning-artifacts.teams.destroy');

        // LearningArtifact Jobs
        Route::get('/learning-artifacts/{learningArtifact}/jobs', [
            LearningArtifactJobsController::class,
            'index',
        ])->name('learning-artifacts.jobs.index');
        Route::post('/learning-artifacts/{learningArtifact}/jobs/{job}', [
            LearningArtifactJobsController::class,
            'store',
        ])->name('learning-artifacts.jobs.store');
        Route::delete('/learning-artifacts/{learningArtifact}/jobs/{job}', [
            LearningArtifactJobsController::class,
            'destroy',
        ])->name('learning-artifacts.jobs.destroy');

        Route::apiResource('menus', MenuController::class);

        // Menu Jobs
        Route::get('/menus/{menu}/jobs', [
            MenuJobsController::class,
            'index',
        ])->name('menus.jobs.index');
        Route::post('/menus/{menu}/jobs/{job}', [
            MenuJobsController::class,
            'store',
        ])->name('menus.jobs.store');
        Route::delete('/menus/{menu}/jobs/{job}', [
            MenuJobsController::class,
            'destroy',
        ])->name('menus.jobs.destroy');

        // Menu Teams
        Route::get('/menus/{menu}/teams', [
            MenuTeamsController::class,
            'index',
        ])->name('menus.teams.index');
        Route::post('/menus/{menu}/teams/{team}', [
            MenuTeamsController::class,
            'store',
        ])->name('menus.teams.store');
        Route::delete('/menus/{menu}/teams/{team}', [
            MenuTeamsController::class,
            'destroy',
        ])->name('menus.teams.destroy');

        // Menu Learning Artifacts
        Route::get('/menus/{menu}/learning-artifacts', [
            MenuLearningArtifactsController::class,
            'index',
        ])->name('menus.learning-artifacts.index');
        Route::post('/menus/{menu}/learning-artifacts/{learningArtifact}', [
            MenuLearningArtifactsController::class,
            'store',
        ])->name('menus.learning-artifacts.store');
        Route::delete('/menus/{menu}/learning-artifacts/{learningArtifact}', [
            MenuLearningArtifactsController::class,
            'destroy',
        ])->name('menus.learning-artifacts.destroy');

        // Menu Quizzes
        Route::get('/menus/{menu}/quizzes', [
            MenuQuizzesController::class,
            'index',
        ])->name('menus.quizzes.index');
        Route::post('/menus/{menu}/quizzes/{quiz}', [
            MenuQuizzesController::class,
            'store',
        ])->name('menus.quizzes.store');
        Route::delete('/menus/{menu}/quizzes/{quiz}', [
            MenuQuizzesController::class,
            'destroy',
        ])->name('menus.quizzes.destroy');

        // Menu Support Links
        Route::get('/menus/{menu}/support-links', [
            MenuSupportLinksController::class,
            'index',
        ])->name('menus.support-links.index');
        Route::post('/menus/{menu}/support-links/{supportLink}', [
            MenuSupportLinksController::class,
            'store',
        ])->name('menus.support-links.store');
        Route::delete('/menus/{menu}/support-links/{supportLink}', [
            MenuSupportLinksController::class,
            'destroy',
        ])->name('menus.support-links.destroy');

        Route::apiResource('learning-paths', LearningPathController::class);

        // LearningPath Learning Artifacts
        Route::get('/learning-paths/{learningPath}/learning-artifacts', [
            LearningPathLearningArtifactsController::class,
            'index',
        ])->name('learning-paths.learning-artifacts.index');
        Route::post(
            '/learning-paths/{learningPath}/learning-artifacts/{learningArtifact}',
            [LearningPathLearningArtifactsController::class, 'store']
        )->name('learning-paths.learning-artifacts.store');
        Route::delete(
            '/learning-paths/{learningPath}/learning-artifacts/{learningArtifact}',
            [LearningPathLearningArtifactsController::class, 'destroy']
        )->name('learning-paths.learning-artifacts.destroy');

        // LearningPath Quizzes
        Route::get('/learning-paths/{learningPath}/quizzes', [
            LearningPathQuizzesController::class,
            'index',
        ])->name('learning-paths.quizzes.index');
        Route::post('/learning-paths/{learningPath}/quizzes/{quiz}', [
            LearningPathQuizzesController::class,
            'store',
        ])->name('learning-paths.quizzes.store');
        Route::delete('/learning-paths/{learningPath}/quizzes/{quiz}', [
            LearningPathQuizzesController::class,
            'destroy',
        ])->name('learning-paths.quizzes.destroy');

        // LearningPath Categories
        Route::get('/learning-paths/{learningPath}/categories', [
            LearningPathCategoriesController::class,
            'index',
        ])->name('learning-paths.categories.index');
        Route::post('/learning-paths/{learningPath}/categories/{category}', [
            LearningPathCategoriesController::class,
            'store',
        ])->name('learning-paths.categories.store');
        Route::delete('/learning-paths/{learningPath}/categories/{category}', [
            LearningPathCategoriesController::class,
            'destroy',
        ])->name('learning-paths.categories.destroy');

        // LearningPath Teams
        Route::get('/learning-paths/{learningPath}/teams', [
            LearningPathTeamsController::class,
            'index',
        ])->name('learning-paths.teams.index');
        Route::post('/learning-paths/{learningPath}/teams/{team}', [
            LearningPathTeamsController::class,
            'store',
        ])->name('learning-paths.teams.store');
        Route::delete('/learning-paths/{learningPath}/teams/{team}', [
            LearningPathTeamsController::class,
            'destroy',
        ])->name('learning-paths.teams.destroy');

        // LearningPath Jobs
        Route::get('/learning-paths/{learningPath}/jobs', [
            LearningPathJobsController::class,
            'index',
        ])->name('learning-paths.jobs.index');
        Route::post('/learning-paths/{learningPath}/jobs/{job}', [
            LearningPathJobsController::class,
            'store',
        ])->name('learning-paths.jobs.store');
        Route::delete('/learning-paths/{learningPath}/jobs/{job}', [
            LearningPathJobsController::class,
            'destroy',
        ])->name('learning-paths.jobs.destroy');

        // LearningPath Users
        Route::get('/learning-paths/{learningPath}/users', [
            LearningPathUsersController::class,
            'index',
        ])->name('learning-paths.users.index');
        Route::post('/learning-paths/{learningPath}/users/{user}', [
            LearningPathUsersController::class,
            'store',
        ])->name('learning-paths.users.store');
        Route::delete('/learning-paths/{learningPath}/users/{user}', [
            LearningPathUsersController::class,
            'destroy',
        ])->name('learning-paths.users.destroy');

        // LearningPath Learning Path Groups
        Route::get('/learning-paths/{learningPath}/learning-path-groups', [
            LearningPathLearningPathGroupsController::class,
            'index',
        ])->name('learning-paths.learning-path-groups.index');
        Route::post(
            '/learning-paths/{learningPath}/learning-path-groups/{learningPathGroup}',
            [LearningPathLearningPathGroupsController::class, 'store']
        )->name('learning-paths.learning-path-groups.store');
        Route::delete(
            '/learning-paths/{learningPath}/learning-path-groups/{learningPathGroup}',
            [LearningPathLearningPathGroupsController::class, 'destroy']
        )->name('learning-paths.learning-path-groups.destroy');

        Route::apiResource('quizzes', QuizController::class);

        // Quiz Quiz Results
        Route::get('/quizzes/{quiz}/quiz-results', [
            QuizQuizResultsController::class,
            'index',
        ])->name('quizzes.quiz-results.index');
        Route::post('/quizzes/{quiz}/quiz-results', [
            QuizQuizResultsController::class,
            'store',
        ])->name('quizzes.quiz-results.store');

        // Quiz Objective Questions
        Route::get('/quizzes/{quiz}/objective-questions', [
            QuizObjectiveQuestionsController::class,
            'index',
        ])->name('quizzes.objective-questions.index');
        Route::post('/quizzes/{quiz}/objective-questions/{objectiveQuestion}', [
            QuizObjectiveQuestionsController::class,
            'store',
        ])->name('quizzes.objective-questions.store');
        Route::delete(
            '/quizzes/{quiz}/objective-questions/{objectiveQuestion}',
            [QuizObjectiveQuestionsController::class, 'destroy']
        )->name('quizzes.objective-questions.destroy');

        // Quiz Categories
        Route::get('/quizzes/{quiz}/categories', [
            QuizCategoriesController::class,
            'index',
        ])->name('quizzes.categories.index');
        Route::post('/quizzes/{quiz}/categories/{category}', [
            QuizCategoriesController::class,
            'store',
        ])->name('quizzes.categories.store');
        Route::delete('/quizzes/{quiz}/categories/{category}', [
            QuizCategoriesController::class,
            'destroy',
        ])->name('quizzes.categories.destroy');

        // Quiz Learning Paths
        Route::get('/quizzes/{quiz}/learning-paths', [
            QuizLearningPathsController::class,
            'index',
        ])->name('quizzes.learning-paths.index');
        Route::post('/quizzes/{quiz}/learning-paths/{learningPath}', [
            QuizLearningPathsController::class,
            'store',
        ])->name('quizzes.learning-paths.store');
        Route::delete('/quizzes/{quiz}/learning-paths/{learningPath}', [
            QuizLearningPathsController::class,
            'destroy',
        ])->name('quizzes.learning-paths.destroy');

        // Quiz Menus
        Route::get('/quizzes/{quiz}/menus', [
            QuizMenusController::class,
            'index',
        ])->name('quizzes.menus.index');
        Route::post('/quizzes/{quiz}/menus/{menu}', [
            QuizMenusController::class,
            'store',
        ])->name('quizzes.menus.store');
        Route::delete('/quizzes/{quiz}/menus/{menu}', [
            QuizMenusController::class,
            'destroy',
        ])->name('quizzes.menus.destroy');

        Route::apiResource('users', UserController::class);

        // User Objective Answers
        Route::get('/users/{user}/objective-answers', [
            UserObjectiveAnswersController::class,
            'index',
        ])->name('users.objective-answers.index');
        Route::post('/users/{user}/objective-answers', [
            UserObjectiveAnswersController::class,
            'store',
        ])->name('users.objective-answers.store');

        // User Quiz Results
        Route::get('/users/{user}/quiz-results', [
            UserQuizResultsController::class,
            'index',
        ])->name('users.quiz-results.index');
        Route::post('/users/{user}/quiz-results', [
            UserQuizResultsController::class,
            'store',
        ])->name('users.quiz-results.store');

        // User Users
        Route::get('/users/{user}/users', [
            UserUsersController::class,
            'index',
        ])->name('users.users.index');
        Route::post('/users/{user}/users', [
            UserUsersController::class,
            'store',
        ])->name('users.users.store');

        // User Experience Details
        Route::get('/users/{user}/experience-details', [
            UserExperienceDetailsController::class,
            'index',
        ])->name('users.experience-details.index');
        Route::post('/users/{user}/experience-details', [
            UserExperienceDetailsController::class,
            'store',
        ])->name('users.experience-details.store');

        // User Learning Path Group Results
        Route::get('/users/{user}/learning-path-group-results', [
            UserLearningPathGroupResultsController::class,
            'index',
        ])->name('users.learning-path-group-results.index');
        Route::post('/users/{user}/learning-path-group-results', [
            UserLearningPathGroupResultsController::class,
            'store',
        ])->name('users.learning-path-group-results.store');

        // User Teams
        Route::get('/users/{user}/teams', [
            UserTeamsController::class,
            'index',
        ])->name('users.teams.index');
        Route::post('/users/{user}/teams/{team}', [
            UserTeamsController::class,
            'store',
        ])->name('users.teams.store');
        Route::delete('/users/{user}/teams/{team}', [
            UserTeamsController::class,
            'destroy',
        ])->name('users.teams.destroy');

        // User Learning Paths
        Route::get('/users/{user}/learning-paths', [
            UserLearningPathsController::class,
            'index',
        ])->name('users.learning-paths.index');
        Route::post('/users/{user}/learning-paths/{learningPath}', [
            UserLearningPathsController::class,
            'store',
        ])->name('users.learning-paths.store');
        Route::delete('/users/{user}/learning-paths/{learningPath}', [
            UserLearningPathsController::class,
            'destroy',
        ])->name('users.learning-paths.destroy');

        // User Achievements
        Route::get('/users/{user}/achievements', [
            UserAchievementsController::class,
            'index',
        ])->name('users.achievements.index');
        Route::post('/users/{user}/achievements/{achievement}', [
            UserAchievementsController::class,
            'store',
        ])->name('users.achievements.store');
        Route::delete('/users/{user}/achievements/{achievement}', [
            UserAchievementsController::class,
            'destroy',
        ])->name('users.achievements.destroy');
    });
