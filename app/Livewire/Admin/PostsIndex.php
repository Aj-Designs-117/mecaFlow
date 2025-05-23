<?php

namespace App\Livewire\Admin;

use App\Models\Post;
use Illuminate\Support\Facades\DB;
use Cloudinary\Cloudinary;
use Illuminate\Support\Facades\Log;
use Livewire\Component;
use Livewire\WithPagination;

class PostsIndex extends Component
{
    use WithPagination;

    public $search = '';
    public $sort = 'id';
    public $direction = 'desc';
    public $id, $title = '', $slug = '', $body = '', $partners = '', $status, $selectedCategories = [];

    public function render()
    {
        $posts = Post::where('user_id', auth()->id())
            ->where(function ($query) {
                $query->where('title', 'like', '%' . $this->search . '%')
                    ->orWhere('slug', 'like', '%' . $this->search . '%');
            })
            ->orderBy($this->sort, $this->direction)
            ->paginate(10);
        return view('livewire.admin.posts-index', compact('posts'));
    }

    public function edit($id)
    {
        $post = Post::where('id', $id)->select('id', 'title', 'slug', 'partners', 'body', 'status')->first();
        $this->id = $post->id;
        $this->title = $post->title;
        $this->slug = $post->slug;
        $this->partners = $post->partners;
        $this->body = strip_tags($post->body);
        $this->status = $post->status;

        return redirect()->route('admin.posts.edit', $this->slug);
    }

    public function destroy($id)
    {
        $user = auth()->user();

        if (! $user->hasRole(['Administrador'])) {
            abort(403, 'No tienes permiso para eliminar posts.');
        }

        try {
            DB::beginTransaction();

            $post = Post::with('postImages')->findOrFail($id);

            $cloudinary = new Cloudinary();

            foreach ($post->postImages as $image) {
                $publicId = $this->extractPublicIdFromUrl($image->image_path);
                if ($publicId) {
                    $cloudinary->uploadApi()->destroy($publicId);
                }
                $image->delete();
            }

            $post->categories()->detach();

            $post->delete();

            DB::commit();

            Log::info('Post eliminado exitosamente', [
                'id' => $post->id,
                'title' => $post->title,
                'deleted_by' => $user->id,
                'ip' => request()->ip()
            ]);

            $this->dispatch('success', ['message' => 'Post eliminado correctamente']);
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            DB::rollBack();

            Log::error('Post no encontrado al intentar eliminar', [
                'requested_id' => $id,
                'error' => $e->getMessage(),
                'modified_by' => auth()->id(),
                'ip' => request()->ip()
            ]);

            $this->dispatch('error', ['message' => 'El post no existe']);
        } catch (\Exception $e) {
            DB::rollBack();

            Log::error('Error al eliminar post', [
                'post_id' => $id,
                'error' => $e->getMessage(),
                'modified_by' => auth()->id(),
                'ip' => request()->ip()
            ]);

            $this->dispatch('error', ['message' => 'Algo salió mal al eliminar el post']);
        }
    }

    private function extractPublicIdFromUrl(string $url): ?string
    {

        $parsedUrl = parse_url($url, PHP_URL_PATH); 

        $parts = explode('/', $parsedUrl);

        $uploadIndex = array_search('upload', $parts);

        if ($uploadIndex === false || !isset($parts[$uploadIndex + 2])) {
            return null;
        }

        $versionIndex = $uploadIndex + 1;
        $pathParts = array_slice($parts, $versionIndex + 1);

        $fileName = array_pop($pathParts);
        $fileNameWithoutExt = pathinfo($fileName, PATHINFO_FILENAME);

        $publicId = implode('/', $pathParts) . '/' . $fileNameWithoutExt;

        return $publicId;
    }
}
