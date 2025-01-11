<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class SpecialitySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $specialities = [
            'Computer Science' => [
                'Artificial Intelligence',
                'Machine Learning',
                'Data Science',
                'Cybersecurity',
                'Software Engineering',
                'Cloud Computing',
                'Human-Computer Interaction',
                'Web Development',
                'Mobile Application Development',
                'Computer Networks'
            ],
            'Engineering' => [
                'Mechanical Engineering',
                'Electrical Engineering',
                'Civil Engineering',
                'Chemical Engineering',
                'Aerospace Engineering',
                'Biomedical Engineering',
                'Environmental Engineering',
                'Industrial Engineering',
                'Materials Science',
                'Robotics'
            ],
            'Medical' => [
                'Cardiology',
                'Neurology',
                'Pediatrics',
                'Dermatology',
                'Oncology',
                'Orthopedics',
                'Surgery',
                'Radiology',
                'Psychiatry',
                'Endocrinology'
            ],
            'Business' => [
                'Finance',
                'Marketing',
                'Human Resources',
                'Operations Management',
                'Entrepreneurship',
                'International Business',
                'Supply Chain Management',
                'Business Analytics',
                'Corporate Strategy',
                'Accounting'
            ],
            'Arts' => [
                'Visual Arts',
                'Performing Arts',
                'Music',
                'Dance',
                'Theater',
                'Film Studies',
                'Creative Writing',
                'Graphic Design',
                'Photography',
                'Sculpture'
            ],
            'Law' => [
                'Criminal Law',
                'Corporate Law',
                'Family Law',
                'Intellectual Property Law',
                'International Law',
                'Environmental Law',
                'Human Rights Law',
                'Tax Law',
                'Labor Law',
                'Constitutional Law'
            ],
            'Social Sciences' => [
                'Sociology',
                'Anthropology',
                'Political Science',
                'Economics',
                'Psychology',
                'Geography',
                'Cultural Studies',
                'Public Administration',
                'International Relations',
                'Gender Studies'
            ],
            'Natural Sciences' => [
                'Physics',
                'Chemistry',
                'Biology',
                'Astronomy',
                'Geology',
                'Environmental Science',
                'Oceanography',
                'Meteorology',
                'Ecology',
                'Genetics'
            ],
            'Education' => [
                'Early Childhood Education',
                'Special Education',
                'Educational Leadership',
                'Curriculum and Instruction',
                'Adult Education',
                'Educational Technology',
                'Higher Education Administration',
                'Counseling and Guidance',
                'Educational Psychology',
                'Teacher Education'
            ],
            'Environmental Studies' => [
                'Environmental Policy',
                'Sustainability Studies',
                'Conservation Biology',
                'Environmental Management',
                'Climate Science',
                'Renewable Energy',
                'Wildlife Conservation',
                'Water Resource Management',
                'Environmental Law',
                'Urban Planning'
            ],
            'Mathematics' => [
                'Pure Mathematics',
                'Applied Mathematics',
                'Statistics',
                'Operations Research',
                'Computational Mathematics',
                'Financial Mathematics',
                'Mathematical Physics',
                'Biostatistics',
                'Cryptography',
                'Actuarial Science'
            ],
            'Humanities' => [
                'History',
                'Philosophy',
                'Literature',
                'Religious Studies',
                'Linguistics',
                'Classics',
                'Ethics',
                'Cultural Studies',
                'Comparative Literature',
                'Art History'
            ],
            'Architecture' => [
                'Urban Planning',
                'Interior Design',
                'Landscape Architecture',
                'Sustainable Architecture',
                'Historic Preservation',
                'Building Science',
                'Architectural Theory',
                'Urban Design',
                'Environmental Design',
                'Housing Design'
            ],
            'Communications' => [
                'Journalism',
                'Public Relations',
                'Advertising',
                'Media Studies',
                'Broadcasting',
                'Corporate Communication',
                'Digital Media',
                'Film Production',
                'Speech Communication',
                'Strategic Communication'
            ],
            'Psychology' => [
                'Clinical Psychology',
                'Counseling Psychology',
                'Cognitive Psychology',
                'Developmental Psychology',
                'Social Psychology',
                'Industrial-Organizational Psychology',
                'Educational Psychology',
                'Forensic Psychology',
                'Health Psychology',
                'Neuropsychology'
            ]
        ];

        foreach ($specialities as $category => $specialities_inner) {
            $parent = \App\Models\Speciality::create([
                'title' => $category,
                'type' => 'speciality area'
            ]);

            foreach ($specialities_inner as $speciality) {
                \App\Models\Speciality::create([
                    'title' => $speciality,
                    'type' => 'speciality',
                    'parent_id' => $parent->id
                ]);
            }
        }

    }
}
