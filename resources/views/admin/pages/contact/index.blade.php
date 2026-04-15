@extends('admin.master.main')

@section('content')

<div class="col-lg-12">
    <div class="d-flex align-items-center mb-3" style="padding-left: 10px; padding-top: 0;">
        
        <div>
            <h4 class="mb-0" style="font-weight: 600; font-size: 1.5rem; color: #0f172a;">Contact Us</h4>
            <p class="text-muted mb-0" style="font-size: 0.9rem;margin-left: 12px;">Company contact information</p>
        </div>
    </div>

    <!-- Full Width Card -->
    <div style="width: 100%;">
        <div style="background: linear-gradient(to bottom, #ffffff, #f8fafc); border-radius: 16px; padding: 40px; box-shadow: 0 4px 20px rgba(0,0,0,0.08); border: 1px solid #e5e7eb; width: 100%;">

            <!-- Header -->
            <div style="text-align: center; margin-bottom: 32px;">
                <div style="width: 64px; height: 64px; background: #ffffff; border-radius: 12px; display: inline-flex; align-items: center; justify-content: center; box-shadow: 0 2px 8px rgba(0,0,0,0.1); margin-bottom: 16px;">
                    <i class="fas fa-building" style="color: #1e293b; font-size: 1.5rem;"></i>
                </div>
                <h3 style="font-weight: 700; color: #0f172a; font-size: 1.75rem; margin-bottom: 8px;">Contact Information</h3>
                <p style="color: #64748b; font-size: 0.95rem; margin: 0;">Get in touch with us</p>
            </div>

            <!-- Row 1 -->
            <div class="row g-4 mb-4">
                <!-- Company Name -->
                <div class="col-md-6">
                    <div style="padding: 20px; background: #ffffff; border-radius: 12px; border: 1px solid #e5e7eb; height: 100%;">
                        <div style="display: flex; align-items: flex-start;">
                            <div style="width: 48px; height: 48px; background: #f1f5f9; border-radius: 12px; display: flex; align-items: center; justify-content: center; margin-right: 16px;">
                                <i class="fas fa-building" style="color: #475569; font-size: 1.2rem;"></i>
                            </div>
                            <div>
                                <p style="font-size: 0.85rem; color: #64748b; margin: 0 0 6px 0; font-weight: 600;">Company Name</p>
                                <p style="font-size: 1rem; color: #1e293b; margin: 0; font-weight: 600;">ELM LODGE RESIDENTIAL CARE HOME</p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Address -->
                <div class="col-md-6">
                    <div style="padding: 20px; background: #ffffff; border-radius: 12px; border: 1px solid #e5e7eb; height: 100%;">
                        <div style="display: flex; align-items: flex-start;">
                            <div style="width: 48px; height: 48px; background: #f1f5f9; border-radius: 12px; display: flex; align-items: center; justify-content: center; margin-right: 16px;">
                                <i class="fas fa-map-marker-alt" style="color: #475569; font-size: 1.2rem;"></i>
                            </div>
                            <div>
                                <p style="font-size: 0.85rem; color: #64748b; margin: 0 0 6px 0; font-weight: 600;">Address</p>
                                <p style="font-size: 1rem; color: #1e293b; margin: 0;">Elm Lodge Residential Care Home, Cluntergate, Horbury, Wakefield WF4 5DB</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Row 2 -->
            <div class="row g-4">
                <!-- Email -->
                <div class="col-md-6">
                    <div style="padding: 20px; background: #ffffff; border-radius: 12px; border: 1px solid #e5e7eb; height: 100%;">
                        <div style="display: flex; align-items: flex-start;">
                            <div style="width: 48px; height: 48px; background: #f1f5f9; border-radius: 12px; display: flex; align-items: center; justify-content: center; margin-right: 16px;">
                                <i class="fas fa-envelope" style="color: #475569; font-size: 1.2rem;"></i>
                            </div>
                            <div>
                                <p style="font-size: 0.85rem; color: #64748b; margin: 0 0 6px 0; font-weight: 600;">Email</p>
                                <a href="mailto:manager@elmlodgecare.co.uk" style="font-size: 1rem; color: #3b82f6; text-decoration: none;">
                                    manager@elmlodgecare.co.uk
                                </a>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Phone -->
                <div class="col-md-6">
                    <div style="padding: 20px; background: #ffffff; border-radius: 12px; border: 1px solid #e5e7eb; height: 100%;">
                        <div style="display: flex; align-items: flex-start;">
                            <div style="width: 48px; height: 48px; background: #f1f5f9; border-radius: 12px; display: flex; align-items: center; justify-content: center; margin-right: 16px;">
                                <i class="fas fa-phone" style="color: #475569; font-size: 1.2rem;"></i>
                            </div>
                            <div>
                                <p style="font-size: 0.85rem; color: #64748b; margin: 0 0 6px 0; font-weight: 600;">Phone</p>
                                <a href="tel:01924262420" style="font-size: 1rem; color: #3b82f6; text-decoration: none;">
                                    019-242-62420
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
</div>

@endsection