<?php

use Illuminate\Foundation\Testing\DatabaseMigrations;

class TagsAPITest extends TestCase
{

    use DatabaseMigrations;
    //use \Illuminate\Foundation\Testing\WithoutMiddleware;

    /**
     * A basic functional test example.
     *
     * @return void
     */
    public function testTagsUseJson()
    {
        // One way to test protected API
        $user = factory(App\User::class)->create();

        $this->get('/tag?api_token=' . $user->api_token)->seeJson()->seeStatusCode(200);
    }

    /**
     * Test tags in database are listed by API
     *
     * @return void
     */
    public function testTagsInDatabaseAreListedByAPI()
    {
        $this->createFakeTags();

        $user = factory(App\User::class)->create();

        // actingAs() is another way to test protected API
        $this->actingAs($user)->get('/tag')
            ->seeJsonStructure([
                '*' => [
                    'title'
                ]
            ])->seeStatusCode(200);
    }

    /**
     * Test tags in database is shown by API
     *
     * @return void
     */
    public function testTagsInDatabaseAreShownByAPI()
    {
        $tag = $this->createFakeTag();
        $user = factory(App\User::class)->create();

        $this->actingAs($user)->get('/tag/' . $tag->id)
            ->seeJsonContains(['title' => $tag->title])
            ->seeStatusCode(200);
    }

    /**
     * Create fake tag
     *
     * @return \App\Tag
     */
    private function createFakeTag() {
        $faker = Faker\Factory::create();
        $tag = new \App\Tag();

        $tag->title = $faker->word;
        $tag->save();

        return $tag;
    }

    /**
     * Create fake tags
     *
     * @param int $count
     * @return \App\Tag
     */
    private function createFakeTags($count = 10) {
        foreach (range(0,$count) as $number) {
            $this->createFakeTag();
        }
    }

    /**
     * Test tags can be posted and saved to database
     *
     * @return void
     */
    public function testTagsCanBePostedAndSavedIntoDatabase()
    {
        $user = factory(App\User::class)->create();

        $data = ['title' => 'Foobar'];
        $this->actingAs($user)->post('/tag',$data)->seeInDatabase('tags',$data);
        $this->actingAs($user)->get('/tag')->seeJsonContains($data)->seeStatusCode(200);
    }

    /**
     * Test tags can be update and see changes on database
     *
     * @return void
     */
    public function testTagsCanBeUpdatedAndSeeChangesInDatabase()
    {
        $user = factory(App\User::class)->create();

        $tag = $this->createFakeTag();
        $data = [ 'title' => 'Learn Laravel'];
        $this->actingAs($user)->put('/tag/' . $tag->id, $data)->seeInDatabase('tags',$data);
        $this->actingAs($user)->get('/tag')->seeJsonContains($data)->seeStatusCode(200);
    }

    /**
     * Test tags can be deleted and not see on database
     *
     * @return void
     */
    public function testTagsCanBeDeletedAndNotSeenOnDatabase()
    {
        $user = factory(App\User::class)->create();

        $tag = $this->createFakeTag();
        $data = [ 'title' => $tag->title];
        $this->actingAs($user)->delete('/tag/' . $tag->id)->notSeeInDatabase('tags',$data);
        $this->actingAs($user)->get('/tag')->dontSeeJson($data)->seeStatusCode(200);
    }

    public function testTagNotFoundErrorCode()
    {
        $user = factory(App\User::class)->create();

        $this->actingAs($user)->get('/tag/500000000')->seeStatusCode(404);
    }

    /**
     * Test api
     * @group security
     * @return void
     */
    public function testApiTokenSecurityNotAuthenticated()
    {
        $this->createFakeTags();
        $this->get('/task')->assertRedirectedTo('/auth/login');

        //$this->get('/api/v1/task')->seeStatusCode(401);
    }

    public function testApiTokenSecurityAuthenticated()
    {
        $this->createFakeTags();

        $user = factory(App\User::class)->create();

        $this->actingAs($user)->get('/tag')
            ->seeJsonStructure([
                '*' => [
                    'title'
                ]
            ])->seeStatusCode(200);
    }


}
