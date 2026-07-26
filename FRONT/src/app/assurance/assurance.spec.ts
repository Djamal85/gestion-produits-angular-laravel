import { ComponentFixture, TestBed } from '@angular/core/testing';

import { Assurance } from './assurance';

describe('Assurance', () => {
  let component: Assurance;
  let fixture: ComponentFixture<Assurance>;

  beforeEach(async () => {
    await TestBed.configureTestingModule({
      imports: [Assurance],
    }).compileComponents();

    fixture = TestBed.createComponent(Assurance);
    component = fixture.componentInstance;
    await fixture.whenStable();
  });

  it('should create', () => {
    expect(component).toBeTruthy();
  });
});
