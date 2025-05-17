namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Models\College;

class CollegeSearchTest extends TestCase
{
    use RefreshDatabase;

    public function test_can_search_for_college()
    {
        College::factory()->create(['CollegeName' => 'Sample College']);
        College::factory()->create(['CollegeName' => 'Another School']);

        $response = $this->get('/colleges?search=Sample');
        $response->assertSee('Sample College');
        $response->assertDontSee('Another School');
    }
}
`
