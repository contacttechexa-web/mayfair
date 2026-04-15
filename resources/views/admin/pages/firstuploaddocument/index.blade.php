<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <!-- Font Awesome 6 -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body>
    <style>
    .doc-container {
        padding: 28px 20px;
        background: #f8fafc;
        min-height: calc(100vh - 80px);
    }

    .doc-header {
        margin-bottom: 32px;
    }

    .doc-header h2 {
        font-weight: 600;
        font-size: 2rem;
        color: #0f172a;
        letter-spacing: -0.3px;
        margin: 0 0 8px 0;
    }

    .doc-header p {
        font-size: 1rem;
        color: #64748b;
        margin: 0;
    }

    .main-card {
        background: #ffffff;
        border-radius: 12px;
        border: 1px solid #e5e7eb;
        box-shadow: 0 1px 2px rgba(0, 0, 0, 0.04);
    }

    .card-header {
        background: #f8fafc;
        border-bottom: 1px solid #e5e7eb;
        padding: 20px 24px;
        display: flex;
        justify-content: space-between;
        align-items: center;
    }

    .card-header h3 {
        margin: 0;
        color: #0f172a;
        font-weight: 600;
        font-size: 1.25rem;
    }

    .card-header .badge {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        color: #ffffff;
        padding: 6px 12px;
        border-radius: 6px;
        font-size: 0.9rem;
    }

    .card-body {
        padding: 32px;
    }

    .documents-grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(280px, 1fr));
        gap: 20px;
    }

    .document-card {
        border: 1px solid #e5e7eb;
        border-radius: 12px;
        padding: 20px;
        transition: all 0.3s ease;
        background: #ffffff;
        cursor: pointer;
    }

    .document-card:hover {
        transform: translateY(-4px);
        border-color: #667eea;
        box-shadow: 0 8px 16px rgba(102, 126, 234, 0.15);
    }

    .document-card a {
        text-decoration: none;
        color: inherit;
        display: block;
    }

    .doc-icon {
        width: 56px;
        height: 56px;
        border-radius: 12px;
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        display: flex;
        align-items: center;
        justify-content: center;
        color: #ffffff;
        font-size: 1.8rem;
        margin-bottom: 16px;
    }

    .doc-name {
        font-weight: 600;
        color: #0f172a;
        font-size: 1.05rem;
        margin-bottom: 8px;
    }

    .doc-link {
        color: #667eea;
        text-decoration: none;
        font-weight: 500;
        transition: color 0.3s ease;
        display: inline-flex;
        align-items: center;
        gap: 8px;
    }

    .doc-link:hover {
        color: #764ba2;
    }

    .empty-state {
        text-align: center;
        padding: 60px 20px;
    }

    .empty-icon {
        font-size: 4rem;
        color: #cbd5e1;
        margin-bottom: 20px;
    }

    .empty-title {
        font-size: 1.25rem;
        color: #0f172a;
        font-weight: 600;
        margin-bottom: 8px;
    }

    .empty-text {
        color: #64748b;
        font-size: 1rem;
    }

    .upload-btn {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        color: #ffffff;
        border: none;
        padding: 12px 24px;
        border-radius: 8px;
        font-weight: 600;
        cursor: pointer;
        transition: all 0.3s ease;
        margin-top: 20px;
        display: inline-flex;
        align-items: center;
        gap: 8px;
    }

    .upload-btn:hover {
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(102, 126, 234, 0.3);
    }

    .status-badge {
        display: inline-block;
        padding: 4px 10px;
        border-radius: 4px;
        font-size: 0.75rem;
        font-weight: 600;
        margin-top: 12px;
    }

    .status-uploaded {
        background: #dcfce7;
        color: #15803d;
    }

    .status-pending {
        background: #fef3c7;
        color: #92400e;
    }

    @media (max-width: 768px) {
        .documents-grid {
            grid-template-columns: 1fr;
        }

        .doc-header h2 {
            font-size: 1.5rem;
        }

        .card-header {
            flex-direction: column;
            align-items: flex-start;
            gap: 12px;
        }
    }
</style>

<div class="doc-container">
    <div class="doc-header">
        <h2 class=""><i class="fas fa-file-alt me-3"></i>  Please Upload Your Documents</h2>
    </div>

    <div class="main-card">
        <div class="card-header">
            <h3>Documents List</h3>
            <div style="display:flex; align-items:center; gap:12px;">
               

                <form id="logout-form-top" action="{{ route('logout') }}" method="POST" style="display:inline;">
                    @csrf
                    <button type="submit" class="upload-btn" style="background: linear-gradient(135deg, #ef4444 0%, #dc2626 100%);">
                        <i class="fas fa-sign-out-alt"></i> Logout
                    </button>
                </form>
            </div>
        </div>

        <div class="card-body">
            @if(!empty($pendingDocs) && count($pendingDocs) > 0)
                <div class="documents-grid">
                    @foreach($pendingDocs as $doc)
                        <a href="{{ route('documents.create', ['title' => $doc]) }}" class="document-card">
                            <div class="doc-icon">
                                @php
                                    $icon = 'fa-solid fa-file'; // default file icon
                                    $lowerDoc = strtolower($doc);
                                    
                                    if(str_contains($lowerDoc, 'cv') || str_contains($lowerDoc, 'resume')) {
                                        $icon = 'fa-solid fa-file-lines'; // CV/Resume file icon
                                    } elseif(str_contains($lowerDoc, 'pass')) {
                                        $icon = 'fa-solid fa-file-lines'; // Pass document also gets file icon
                                    } elseif(str_contains($lowerDoc, 'cv2') || str_contains($lowerDoc, 'cv 2')) {
                                        $icon = 'fa-solid fa-file-lines'; // CV2 file icon
                                    } elseif(str_contains($lowerDoc, 'pdf')) {
                                        $icon = 'fa-solid fa-file-pdf'; // PDF file icon
                                    } elseif(str_contains($lowerDoc, 'word') || str_contains($lowerDoc, 'doc')) {
                                        $icon = 'fa-solid fa-file-word'; // Word file icon
                                    } elseif(str_contains($lowerDoc, 'excel') || str_contains($lowerDoc, 'xls')) {
                                        $icon = 'fa-solid fa-file-excel'; // Excel file icon
                                    } elseif(str_contains($lowerDoc, 'image') || str_contains($lowerDoc, 'jpg') || str_contains($lowerDoc, 'png')) {
                                        $icon = 'fa-solid fa-file-image'; // Image file icon
                                    } elseif(str_contains($lowerDoc, 'archive') || str_contains($lowerDoc, 'zip')) {
                                        $icon = 'fa-solid fa-file-zipper'; // Archive file icon
                                    } elseif(str_contains($lowerDoc, 'audio') || str_contains($lowerDoc, 'mp3')) {
                                        $icon = 'fa-solid fa-file-audio'; // Audio file icon
                                    } elseif(str_contains($lowerDoc, 'video') || str_contains($lowerDoc, 'mp4')) {
                                        $icon = 'fa-solid fa-file-video'; // Video file icon
                                    } elseif(str_contains($lowerDoc, 'code') || str_contains($lowerDoc, 'html') || str_contains($lowerDoc, 'js')) {
                                        $icon = 'fa-solid fa-file-code'; // Code file icon
                                    }
                                @endphp
                                <i class="{{ $icon }}"></i>
                            </div>
                            <div class="doc-name">{{ $doc }}</div>
                        </a>
                    @endforeach
                </div>
            @else
                    <div class="empty-state">
                    <div class="empty-icon">
                        <i class="fas fa-check-circle" style="color: #10b981;"></i>
                    </div>
                    <div class="empty-title">All Documents Uploaded!</div>
                    <div class="empty-text">Congratulations! You have successfully uploaded all required documents.</div>
                    <div style="display:flex; gap:12px; align-items:center; justify-content:center;">
                        <button class="upload-btn" onclick="window.location.href='{{ route('dashboard') }}'">
                            <i class="fas fa-home"></i>Go to Dashboard
                        </button>

                        <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display:inline;">
                            @csrf
                            <button type="submit" class="upload-btn" style="background: linear-gradient(135deg, #ef4444 0%, #dc2626 100%);">
                                <i class="fas fa-sign-out-alt"></i> Logout
                            </button>
                        </form>
                    </div>
                </div>
            @endif
        </div>


    </div>
</div>

</body>
</html>