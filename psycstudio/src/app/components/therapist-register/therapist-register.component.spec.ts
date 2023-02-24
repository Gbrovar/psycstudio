import { ComponentFixture, TestBed } from '@angular/core/testing';

import { TherapistRegisterComponent } from './therapist-register.component';

describe('TherapistRegisterComponent', () => {
  let component: TherapistRegisterComponent;
  let fixture: ComponentFixture<TherapistRegisterComponent>;

  beforeEach(async () => {
    await TestBed.configureTestingModule({
      declarations: [ TherapistRegisterComponent ]
    })
    .compileComponents();

    fixture = TestBed.createComponent(TherapistRegisterComponent);
    component = fixture.componentInstance;
    fixture.detectChanges();
  });

  it('should create', () => {
    expect(component).toBeTruthy();
  });
});
