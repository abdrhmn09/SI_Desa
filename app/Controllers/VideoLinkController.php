<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\VideoLinkModel;

class VideoLinkController extends BaseController
{
    protected VideoLinkModel $videoModel;

    public function __construct()
    {
        $this->videoModel = new VideoLinkModel();
    }

    public function index()
    {
        $videos = $this->videoModel->orderBy('created_at', 'DESC')->findAll();
        // Konversi URL ke embed untuk ditampilkan di tabel
        foreach ($videos as &$v) {
            $v['embed_url'] = VideoLinkModel::toEmbedUrl($v['url_video']);
        }

        return view('video/index', [
            'title'  => 'Manajemen Video',
            'videos' => $videos,
        ]);
    }

    public function create()
    {
        return view('video/create', [
            'title'      => 'Tambah Video',
            'validation' => \Config\Services::validation(),
        ]);
    }

    public function store()
    {
        $rules = [
            'judul'     => 'required|max_length[255]',
            'url_video' => 'required|max_length[500]|valid_url_strict',
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $this->videoModel->save([
            'judul'     => $this->request->getPost('judul'),
            'deskripsi' => $this->request->getPost('deskripsi'),
            'url_video' => $this->request->getPost('url_video'),
        ]);

        return redirect()->to('/video')->with('success', 'Video berhasil ditambahkan.');
    }

    public function edit($id)
    {
        $video = $this->videoModel->find($id);
        if (!$video) throw new \CodeIgniter\Exceptions\PageNotFoundException();

        return view('video/edit', [
            'title'      => 'Edit Video',
            'video'      => $video,
            'validation' => \Config\Services::validation(),
        ]);
    }

    public function update($id)
    {
        $video = $this->videoModel->find($id);
        if (!$video) throw new \CodeIgniter\Exceptions\PageNotFoundException();

        $rules = [
            'judul'     => 'required|max_length[255]',
            'url_video' => 'required|max_length[500]|valid_url_strict',
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $this->videoModel->update($id, [
            'judul'     => $this->request->getPost('judul'),
            'deskripsi' => $this->request->getPost('deskripsi'),
            'url_video' => $this->request->getPost('url_video'),
        ]);

        return redirect()->to('/video')->with('success', 'Video berhasil diperbarui.');
    }

    public function delete($id)
    {
        $video = $this->videoModel->find($id);
        if (!$video) throw new \CodeIgniter\Exceptions\PageNotFoundException();

        $this->videoModel->delete($id);
        return redirect()->to('/video')->with('success', 'Video berhasil dihapus.');
    }
}
