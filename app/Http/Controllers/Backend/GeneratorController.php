<?php

namespace App\Http\Controllers\Backend;

use Inertia\Inertia;
use Illuminate\Http\Request;
use App\Models\Backend\Question;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
use App\Http\Requests\QuestionRequest;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Validator;

class GeneratorController extends Controller
{
    //

    public function generator()
    {
        return Inertia::render('Backend/Questions/Generator');
    }

    public function generate()
    {

        $questions = $this->getQuestions();

        $count = 0;

        foreach ($questions as $question) {

            //$validatedData = $question->validated();
            //$this->store($question);

            // Create Question
            $questionData = Question::create([
                'id' => $question['id'],
                'title' => $question['title'],
                'question_type' => $question['question_type'],
                'position' => $question['position'],
                'code_snippet' => $question['code_snippet'],
                'exam_id' => $question['exam_id'],
            ]);

            // Create options
            $questionData->options()->create([
                'id' => $question['option_id'],
                'correct_answer' => $question['correct_answer'],
                'explanation' => $question['explanation'],
            ]);

            // Update options optionlist
            $questionData->options()->update([
                'options' => $question['options'],
                'correct_answer' => $question['correct_answer'],
                'explanation' => $question['explanation'],
            ]);
            $count++;
            Log::info("Count is" . $count);
            //Log::info("Count is ${count+1}");
        }
    }

    // public function store(QuestionRequest $request)
    // {

    //     // Retrieve the validated input data...
    //     //If it's valid, it will proceed. If it's not valid, throws a ValidationException.
    //     $validatedData = $request->validated();

    //     // Create Question
    //     $question = Question::create([
    //         'id' => $request->id,
    //         'title' => $request->title,
    //         'question_type' => $request->question_type,
    //         'position' => $request->position,
    //         'code_snippet' => $request->code_snippet,
    //         'exam_id' => $request->exam_id,
    //     ]);

    //     // Create options
    //     $question->options()->create([
    //         'id' => $request->option_id,
    //         'correct_answer' => $request->correct_answer,
    //         'explanation' => $request->explanation,
    //     ]);

    //     // Update options optionlist
    //     $question->options()->update([
    //         'options' => $request->options,
    //         'correct_answer' => $request->correct_answer,
    //         'explanation' => $request->explanation,
    //     ]);

    //     //return to_route('admin.questions.index')->with('success', 'Question created.');
    // }

    public function getQuestions(): array
    {
        return array(
            0 =>
            array(
                'id' => 'c3723685-fd43-45f0-a924-779e230a25bf',
                'option_id' => '3746504e-7092-44f2-a2b2-d71620341f4e',
                'exam_id' => '9c032389-82e6-4f91-8187-e61c0792b482',
                'question_type' => 'mcq',
                'title' => 'The equation ¹⁵⁰X₆₂=> ¹⁵⁰Y₆₃ + -1 + energy, represents',
                'options' =>
                array(
                    'option_a' => 'Alpha decay',
                    'option_b' => 'Beta-decay',
                    'option_c' => 'Gamma decay',
                    'option_d' => 'Photon emission',
                ),
                'correct_answer' => 'option_a',
                'explanation' => 'The correct answer is option_a (Alpha decay). This is because the given equation represents the process of alpha decay, where an alpha particle (42He) is emitted from the nucleus. This is a characteristic feature of alpha decay, distinguishing it from other decay processes like beta decay, gamma decay, or photon emission.',
                'code_snippet' => NULL,
                'position' => '1',
            ),
            1 =>
            array(
                'id' => 'c3c07e14-7a0c-477b-a16d-fa6dbd561e47',
                'option_id' => '136fb6a1-9acc-4304-90e7-4766bfac3b03',
                'exam_id' => '9c032389-82e6-4f91-8187-e61c0792b482',
                'question_type' => 'mcq',
                'title' => 'The ice and steam points of a thermometer are 20mm and 100mm respectively. A temperature of 75 degree celsius corresponds to Y mm on the thermometer. What is Y?',
                'options' =>
                array(
                    'option_a' => '100mm',
                    'option_b' => '70mm',
                    'option_c' => '80mm',
                    'option_d' => '60mm',
                ),
                'correct_answer' => 'option_c',
                'explanation' => 'The correct answer is option_c (80mm). This is because the ice and steam points on a thermometer represent the limits of its scale. The distance between these points is divided equally, so each degree corresponds to the same length. Therefore, at 75 degrees Celsius, which is three-fourths of the way between the ice and steam points (20mm and 100mm), the length on the thermometer would be 80mm.',
                'code_snippet' => NULL,
                'position' => '2',
            ),
            2 =>
            array(
                'id' => 'fdcb5d1f-ddce-4ba8-9bb4-79b0d22719e6',
                'option_id' => '0c17c837-3c76-40e9-b1a9-5bbc8c2e95d5',
                'exam_id' => '9c032389-82e6-4f91-8187-e61c0792b482',
                'question_type' => 'mcq',
                'title' => 'When a yellow card is observed through a blue glass, the card would appear as',
                'options' =>
                array(
                    'option_a' => 'black',
                    'option_b' => 'green',
                    'option_c' => 'red',
                    'option_d' => 'white',
                ),
                'correct_answer' => 'option_b',
                'explanation' => 'The correct answer is option_b (green). When a yellow card is observed through a blue glass, the blue glass acts as a color filter. Yellow light is complementary to blue, so the blue glass absorbs the yellow light and allows only the complementary color, which is green, to pass through. Therefore, the yellow card would appear green when viewed through the blue glass.',
                'code_snippet' => NULL,
                'position' => '3',
            ),
            3 =>
            array(
                'id' => '5f6712cb-3277-4789-ac39-236a12da8307',
                'option_id' => 'e3dcae77-8fdf-43b3-8c8b-80c8d197f302',
                'exam_id' => '9c032389-82e6-4f91-8187-e61c0792b482',
                'question_type' => 'mcq',
                'title' => 'In a nuclear plant, the final mass of the products is 6.32×10-²⁷kg, while the initial mass of the reactant is 6.30×10-²⁷kg, the energy released in the process is (speed of light in vacuum 3.0×10⁸m/s, 1eV = 1.6×10-¹⁹J)</p>',
                'options' =>
                array(
                    'option_a' => '11.25meV',
                    'option_b' => '11.25 MJ',
                    'option_c' => '12.25MJ',
                    'option_d' => '12.25meV',
                ),
                'correct_answer' => 'option_b',
                'explanation' => 'The correct answer is option_b (11.25 MJ). The energy released in a nuclear reaction is calculated using Einstein\'s mass-energy equivalence principle (E=mc²). The mass difference between the initial and final masses is converted into energy. The correct conversion yields 11.25 MJ, taking into account the speed of light and the given mass values.',
                'code_snippet' => NULL,
                'position' => '4',
            ),
            4 =>
            array(
                'id' => '37b4dddf-cb36-4396-a306-084c36bb10ba',
                'option_id' => '6bd77d9b-61fd-4cb6-a319-4dd53a8d4f3a',
                'exam_id' => '9c032389-82e6-4f91-8187-e61c0792b482',
                'question_type' => 'mcq',
                'title' => 'A 1.5kg stone was thrown vertically upward with an initial velocity of 42m/s, What is the potential energy of the stone at the highest point reached.',
                'options' =>
                array(
                    'option_a' => '3.15J',
                    'option_b' => '13.23J',
                    'option_c' => '26.46J',
                    'option_d' => '63.00J',
                ),
                'correct_answer' => 'option_c',
                'explanation' => 'The correct answer is option_c (26.46J). The potential energy at the highest point in a vertical projectile motion is given by the formula PE = mgh. Substituting the values (mass = 1.5kg, g = 9.8 m/s², h = 42m), we get PE = 1.5 * 9.8 * 42 = 26.46J.',
                'code_snippet' => NULL,
                'position' => '5',
            ),
            5 =>
            array(
                'id' => '11ee030f-ae42-4c37-8502-5ff6bc8bfbb6',
                'option_id' => '040ca14a-52b9-4ca5-9a17-c7c8d8c24c4e',
                'exam_id' => '9c032389-82e6-4f91-8187-e61c0792b482',
                'question_type' => 'mcq',
                'title' => 'When two objects P and Q are supplied with the same quantity of heat, the temperature change in p is observed to be twice that of Q. The mass of P is half that of Q. The ratio of the specific heat of P to Q is',
                'options' =>
                array(
                    'option_a' => '1:4',
                    'option_b' => '4:1',
                    'option_c' => '1:1',
                    'option_d' => '2:1',
                ),
                'correct_answer' => 'option_d',
                'explanation' => 'The correct answer is option_d (2:1). The ratio of specific heat capacities (Cp/Cv) for two substances is equal to the ratio of the temperature changes (?T) for the same amount of heat supplied. In this scenario, since the temperature change in P is twice that of Q and the mass of P is half that of Q, the ratio of Cp for P to Q is 2:1.',
                'code_snippet' => NULL,
                'position' => '6',
            ),
            6 =>
            array(
                'id' => '5885e71f-1d58-4bb6-aa92-b42b34d3ae5c',
                'option_id' => '94a383f9-8565-4ba7-a7a7-6d18b4b721ec',
                'exam_id' => '9c032389-82e6-4f91-8187-e61c0792b482',
                'question_type' => 'mcq',
                'title' => 'The following statements were made by some students describing what happened during the determination of the melting point of solids1. The temperature of the solid was constant until melting started2. The temperature of the solid rose until melting started</p>3. During melting, the temperature was rising</p>4. During melting, the temperature was constant</p>5. The temperature continued to rise after all the solid had melted.</p>6. The temperature stopped rising after all the solid had melted. Which of the following gives correct statements in the right order?</p>',
                'options' =>
                array(
                    'option_a' => '2, 4 and 5',
                    'option_b' => '2, 3 and 6',
                    'option_c' => '1, 3 and 6',
                    'option_d' => '1, 3 and 5',
                ),
                'correct_answer' => 'option_b',
                'explanation' => 'The correct answer is option_b (2, 3, and 6). The correct order of statements during the determination of the melting point of solids is 2, 3, and 6. Initially, the temperature of the solid rises until melting starts (2), during melting, the temperature continues to rise (3), and after all the solid has melted, the temperature stops rising (6).',
                'code_snippet' => NULL,
                'position' => '7',
            ),
            7 =>
            array(
                'id' => 'ac6e44d8-afa6-40b6-b4f7-78577c1b2efd',
                'option_id' => '878e5291-fd4e-4fce-b50f-e16a26132831',
                'exam_id' => '9c032389-82e6-4f91-8187-e61c0792b482',
                'question_type' => 'mcq',
                'title' => 'A silver spoon and a wooden spoon are both at room temperature. The silver spoon is cooler to touch because silver',
                'options' =>
                array(
                    'option_a' => 'has a greater density',
                    'option_b' => 'can be polished',
                    'option_c' => 'is a less absorbent material than wood',
                    'option_d' => 'is a better conductor of heat',
                ),
                'correct_answer' => 'option_d',
                'explanation' => 'The correct answer is option_d (is a better conductor of heat). The silver spoon feels cooler to touch because silver is a better conductor of heat than wood. It conducts heat away from the skin more efficiently, making it feel cooler compared to the wooden spoon.',
                'code_snippet' => NULL,
                'position' => '8',
            ),
            8 =>
            array(
                'id' => '12f72170-9e02-4c35-bc57-d8b6a5a4c6d7',
                'option_id' => '9766e512-1649-4cd3-b36b-328b458b59d2',
                'exam_id' => '9c032389-82e6-4f91-8187-e61c0792b482',
                'question_type' => 'mcq',
                'title' => 'A long jumper leaves the ground at an angle of 20 degrees above the horizontal and at a speed of 11m/s. How far does it jump in the horizontal direction?',
                'options' =>
                array(
                    'option_a' => '0.38m',
                    'option_b' => '7.49m',
                    'option_c' => '8.45m',
                    'option_d' => '0m',
                ),
                'correct_answer' => 'option_c',
                'explanation' => 'The correct answer is option_c (8.45m). The horizontal distance covered by a projectile launched at an angle can be calculated using the horizontal component of the initial velocity. In this case, the horizontal component is given by v0 * cos(?), where v0 is the initial velocity (42m/s) and ? is the launch angle (20 degrees). The calculation results in 42 * cos(20) ? 8.45m.',
                'code_snippet' => NULL,
                'position' => '9',
            ),
            9 =>
            array(
                'id' => '80788e04-4c93-4fb3-907c-4a77d901127d',
                'option_id' => '3509b8f9-4728-4d20-96fb-bd5d90525ad5',
                'exam_id' => '9c032389-82e6-4f91-8187-e61c0792b482',
                'question_type' => 'mcq',
                'title' => 'The thrust due to hydrostatic pressure alone on the bottom of a fish tank which is 60cm x 40cm when the depth of water is 30cm is?',
                'options' =>
                array(
                    'option_a' => '8N',
                    'option_b' => '12N',
                    'option_c' => '720N',
                    'option_d' => '24N',
                ),
                'correct_answer' => 'option_c',
                'explanation' => 'The correct answer is option_c (720N). The thrust due to hydrostatic pressure on the bottom of the fish tank is given by the formula F = P * A, where P is the pressure and A is the area. The pressure is determined by the depth of water, and in this case, the area is given by the dimensions of the tank. Calculating with the provided values yields 720N.',
                'code_snippet' => NULL,
                'position' => '10',
            ),
            10 =>
            array(
                'id' => 'd97f4b97-1bc1-4c16-83e3-0b98dec1ef25',
                'option_id' => '2d594d61-7192-4d7a-824e-dc2330657605',
                'exam_id' => '9c032389-82e6-4f91-8187-e61c0792b482',
                'question_type' => 'mcq',
                'title' => 'An object of mass 50g is suspended from the end of a spiral spring of force constant 0.5N/m, the body is set into simple harmonic motion with 0.3m displacement. The period of the motion is',
                'options' =>
                array(
                    'option_a' => '1.00s',
                    'option_b' => '1.99s',
                    'option_c' => '3.00s',
                    'option_d' => '2.5s',
                ),
                'correct_answer' => 'option_a',
                'explanation' => 'The correct answer is option_a (1.00s). The period of simple harmonic motion for a mass-spring system is given by T = 2pv(m/k), where m is the mass and k is the force constant. Substituting the given values (m = 0.05kg, k = 0.5N/m) yields T = 2pv(0.05/0.5) ? 1.00s.',
                'code_snippet' => NULL,
                'position' => '11',
            ),
            11 =>
            array(
                'id' => '4743a4d8-4881-4049-8c06-608cbec597dd',
                'option_id' => '7924772d-85b1-41c9-88f6-e724f759112a',
                'exam_id' => '9c032389-82e6-4f91-8187-e61c0792b482',
                'question_type' => 'mcq',
                'title' => 'If 21g of alcohol of density 0.7gcm-³ is mixed with 10g of water, what would be the density of the resulting mixture?',
                'options' =>
                array(
                    'option_a' => '780gcm-³',
                    'option_b' => '0.78gcm-³',
                    'option_c' => '30gcm-³',
                    'option_d' => '10gcm-³',
                ),
                'correct_answer' => 'option_b',
                'explanation' => 'The correct answer is option_b (0.78gcm?³). The density of the resulting mixture is calculated by adding the masses of alcohol and water and dividing by the total volume. In this case, (21g + 10g) / (50cm³ + 10cm³) = 31g / 60cm³ ? 0.78gcm?³.',
                'code_snippet' => NULL,
                'position' => '12',
            ),
            12 =>
            array(
                'id' => 'f37173fc-ffbe-4eb3-855b-7c64f5b006d0',
                'option_id' => 'bfbd6ea0-cbb1-4963-969d-5c4fa3c29903',
                'exam_id' => '9c032389-82e6-4f91-8187-e61c0792b482',
                'question_type' => 'mcq',
                'title' => 'Two masses 50g and 70g are suspended from the respective ends of a light metre rule, the centre of gravity of the system is',
                'options' =>
                array(
                    'option_a' => '50.0cm',
                    'option_b' => '52.3cm',
                    'option_c' => '70.2cm',
                    'option_d' => '80.4cm',
                ),
                'correct_answer' => 'option_b',
                'explanation' => 'The correct answer is option_b (52.3cm). The center of gravity of the system is located at a point along the ruler that balances the torques due to the masses. The formula for this is (m1 * d1 = m2 * d2), where m1 and m2 are the masses and d1 and d2 are their distances from the pivot. Solving for the center of gravity position gives 52.3cm.',
                'code_snippet' => NULL,
                'position' => '13',
            ),
            13 =>
            array(
                'id' => 'e7966760-201a-4a2c-aebc-48f0f68d670a',
                'option_id' => '28e5ea52-d2f8-4f77-ada1-4a2c07bb094a',
                'exam_id' => '9c032389-82e6-4f91-8187-e61c0792b482',
                'question_type' => 'mcq',
                'title' => 'A transformer which can produce 10V from a 240V a.c supply has an efficiency of 60%. If the current in the secondary winding coil is 15A, the current in the primary coil is',
                'options' =>
                array(
                    'option_a' => '15.0 A',
                    'option_b' => '1.041 A',
                    'option_c' => '16.04 A',
                    'option_d' => '13.96 A',
                ),
                'correct_answer' => 'option_d',
                'explanation' => 'The correct answer is option_d (13.96 A). The current in the primary coil can be calculated using the formula I1 = (V1 * ?) / V2, where V1 and V2 are the voltages across the primary and secondary coils, respectively, and ? is the efficiency. Substituting the given values yields I1 = (240V * 0.6) / 10V = 14.4A. Rounding off, the current in the primary coil is approximately 13.96 A.',
                'code_snippet' => NULL,
                'position' => '14',
            ),
            14 =>
            array(
                'id' => 'f5029ee3-80d5-4f74-b012-a251551be04d',
                'option_id' => '40566616-630e-473c-b2d3-3fcce65f52ac',
                'exam_id' => '9c032389-82e6-4f91-8187-e61c0792b482',
                'question_type' => 'mcq',
                'title' => 'The acceleration due to gravity',
                'options' =>
                array(
                    'option_a' => 'increases with increasing altitude',
                    'option_b' => 'decreases with increasing altitude',
                    'option_c' => 'increases with an increase in the square of the altitude',
                    'option_d' => 'is not affected by the altitude',
                ),
                'correct_answer' => 'option_d',
                'explanation' => 'The correct answer is option_d (is not affected by the altitude). The acceleration due to gravity is not affected by altitude. While gravity does decrease with increasing altitude, the square of the altitude is in the denominator of the gravitational force formula, leading to a cancellation effect, and the net acceleration remains constant.',
                'code_snippet' => NULL,
                'position' => '15',
            ),
            15 =>
            array(
                'id' => '8fced4e3-df64-4322-8871-166b62bafb40',
                'option_id' => 'fa8b681b-621d-4a35-bba3-931146dddaf9',
                'exam_id' => '9c032389-82e6-4f91-8187-e61c0792b482',
                'question_type' => 'mcq',
                'title' => 'A nail is pulled from a wall with a string tied to the nail. If the string is inclined at an angle of 30 degrees to the wall and the tension in the string is 50N, the effective force used in pulling the nail is:',
                'options' =>
                array(
                    'option_a' => '25N',
                    'option_b' => '25 SQRT(3)',
                    'option_c' => '50N',
                    'option_d' => '50 SQRT(3)',
                ),
                'correct_answer' => 'option_b',
                'explanation' => 'The correct answer is option_b (25 SQRT(3)). The effective force used in pulling the nail is the horizontal component of the tension in the string. This component is given by T * cos(?), where T is the tension and ? is the angle of inclination. Substituting the given values (T = 50N, ? = 30 degrees) yields 50 * cos(30) ? 25 SQRT(3) N.',
                'code_snippet' => NULL,
                'position' => '16',
            ),
            16 =>
            array(
                'id' => '4488b065-4045-43bf-9b91-06d978e70a25',
                'option_id' => '1e9702a3-9ab7-439f-8f90-fa3cad692875',
                'exam_id' => '9c032389-82e6-4f91-8187-e61c0792b482',
                'question_type' => 'mcq',
                'title' => 'The electromagnetic waves that are sensitive to temperature changes a',
                'options' =>
                array(
                    'option_a' => 'Ultra-violet rays',
                    'option_b' => 'Gamma-rays',
                    'option_c' => 'Infra-red rays',
                    'option_d' => 'X-rays',
                ),
                'correct_answer' => 'option_c',
                'explanation' => 'The correct answer is option_c (Infra-red rays). Electromagnetic waves sensitive to temperature changes are in the infrared region. Infrared rays are commonly used in thermography and are associated with heat radiation. Ultraviolet, gamma, and X-rays are not typically sensitive to temperature changes.',
                'code_snippet' => NULL,
                'position' => '17',
            ),
            17 =>
            array(
                'id' => 'e340b6b7-9f39-4a82-a9b2-5837a207d21d',
                'option_id' => 'd1aa9698-87c1-4760-afed-f443a5b2f3c7',
                'exam_id' => '9c032389-82e6-4f91-8187-e61c0792b482',
                'question_type' => 'mcq',
                'title' => 'A boy of mass m, suspended from a spring, is put into simple harmonic motion. If the motion has amplitude A and the spring constant k, the maximum potential energy of the mass is',
                'options' =>
                array(
                    'option_a' => 'KA',
                    'option_b' => '0.5 kA²',
                    'option_c' => 'MKA',
                    'option_d' => 'kA²/m',
                ),
                'correct_answer' => 'option_b',
                'explanation' => 'The correct answer is option_b (0.5 kA²). The maximum potential energy of a mass-spring system in simple harmonic motion is given by the formula PE_max = 0.5 kA², where k is the force constant and A is the amplitude of the motion. Therefore, the maximum potential energy is proportional to the square of the amplitude.',
                'code_snippet' => NULL,
                'position' => '18',
            ),
            18 =>
            array(
                'id' => '1d053d7f-6015-4f52-ba4e-965e095ddcba',
                'option_id' => '8e340524-ed20-4474-8131-95c48a8a2035',
                'exam_id' => '9c032389-82e6-4f91-8187-e61c0792b482',
                'question_type' => 'mcq',
                'title' => 'A transformer connected to a 240V a.c, source has 500 turns in its primary winding and 25 turns in its secondary winding. Calculate the e.m.f induced in the secondary winding',
                'options' =>
                array(
                    'option_a' => '9.6 V',
                    'option_b' => '12.0 V',
                    'option_c' => '120.0 V',
                    'option_d' => '52.1 V',
                ),
                'correct_answer' => 'option_d',
                'explanation' => 'The correct answer is option_d (52.1 V). The induced emf in the secondary winding of a transformer is given by the formula E2 = (N2/N1) * E1, where N1 and N2 are the number of turns in the primary and secondary windings, respectively, and E1 is the applied voltage. Substituting the given values (N1 = 500, N2 = 25, E1 = 240V) yields E2 = (25/500) * 240V = 52.1V.',
                'code_snippet' => NULL,
                'position' => '19',
            ),
            19 =>
            array(
                'id' => '54d035cf-860b-47d1-a08d-42414cca7812',
                'option_id' => '049b9d24-96a1-47be-b151-a7330d42640b',
                'exam_id' => '9c032389-82e6-4f91-8187-e61c0792b482',
                'question_type' => 'mcq',
                'title' => 'The fundamental frequency of vibration of a sonometer wire may be halved by',
                'options' =>
                array(
                    'option_a' => 'doubling the length of the wire',
                    'option_b' => 'doubling the mass of the wire',
                    'option_c' => 'reducing the tension by half',
                    'option_d' => 'reducing the absolute temperature',
                ),
                'correct_answer' => 'option_a',
                'explanation' => 'The correct answer is option_a (doubling the length of the wire). The fundamental frequency of vibration of a sonometer wire is inversely proportional to the length of the wire. Doubling the length of the wire would halve the fundamental frequency. Changes in mass, tension, or absolute temperature do not directly halve the fundamental frequency.',
                'code_snippet' => NULL,
                'position' => '20',
            ),
            20 =>
            array(
                'id' => 'ca2f960b-eaab-49ba-a213-797fedc87e65',
                'option_id' => '669bed46-75c0-4283-9ae4-cf308dc9ebdb',
                'exam_id' => '9c032389-82e6-4f91-8187-e61c0792b482',
                'question_type' => 'mcq',
                'title' => 'A car of mass 800kg attains a speed of 25m/s in 20 secs. The power developed in the engine is',
                'options' =>
                array(
                    'option_a' => '1 . 25 x 10⁴W',
                    'option_b' => '2 . 50 x 10⁴W',
                    'option_c' => '1 . 25 x 10⁶W',
                    'option_d' => '2 . 50 x 10⁶W',
                ),
                'correct_answer' => 'option_c',
                'explanation' => 'The correct answer is option_c (1.25 x 106W). The power developed in the engine is calculated using the formula P = W/t, where W is the work done and t is the time taken. The work done is given by W = ?KE, where ?KE is the change in kinetic energy. Substituting the given values (mass = 800kg, initial velocity = 0m/s, final velocity = 25m/s, time = 20s) yields P = (800 * (25² - 0²)) / 20 = 1.25 x 106W.',
                'code_snippet' => NULL,
                'position' => '21',
            ),
            21 =>
            array(
                'id' => '689eef8a-a9e3-4feb-972e-622b97606d1c',
                'option_id' => '37c94ee0-776d-45e5-919a-dc2542fb26ab',
                'exam_id' => '9c032389-82e6-4f91-8187-e61c0792b482',
                'question_type' => 'mcq',
                'title' => 'When the brakes in a car are applied, the frictional force on the tyres',
                'options' =>
                array(
                    'option_a' => 'is a disadvantage because it is in the direction of the motion of the car',
                    'option_b' => 'is a disadvantage because it is in the opposite direction of the motion of the car',
                    'option_c' => 'is an advantage because it is in the direction of the motion of the car',
                    'option_d' => 'is an advantage because it is in the opposite direction of the motion of the car',
                ),
                'correct_answer' => 'option_b',
                'explanation' => 'The correct answer is option_b (is a disadvantage because it is in the opposite direction of the motion of the car). When the brakes are applied in a car, the frictional force on the tires is in the opposite direction of the motion of the car. This force is necessary to decelerate and eventually bring the car to a stop.',
                'code_snippet' => NULL,
                'position' => '22',
            ),
            22 =>
            array(
                'id' => 'ebaee17f-3ae2-4413-9900-966f56deb16c',
                'option_id' => '03b70b5e-edcb-4795-b954-d1749b3f2180',
                'exam_id' => '9c032389-82e6-4f91-8187-e61c0792b482',
                'question_type' => 'mcq',
                'title' => 'If the stress on a wire is 10⁷NM-² and the wire is stretched from its original length of 10.00 cm to 10.05 cm. The young’s modulus of the wire is',
                'options' =>
                array(
                    'option_a' => '5 . 0 x 10⁴Nm-²',
                    'option_b' => '5 . 0 x 10⁵Nm-²',
                    'option_c' => '2 . 0 x 10⁸Nm-²',
                    'option_d' => '2 . 0 x 10⁹Nm-²',
                ),
                'correct_answer' => 'option_d',
                'explanation' => 'The correct answer is option_d (2.0 x 10?Nm?²). Young\'s modulus (Y) is given by the formula Y = (F/A) / (?L/L0), where F is the force applied, A is the cross-sectional area, ?L is the change in length, and L0 is the original length. Substituting the given values (F = 107N, A = (p/4) * (0.01)²m², ?L = 0.0005m, L0 = 0.1m) yields Y = (107 / ((p/4) * (0.01)²) / (0.0005 / 0.1) = 2.0 x 10?Nm?².',
                'code_snippet' => NULL,
                'position' => '23',
            ),
            23 =>
            array(
                'id' => 'e3df8854-468a-444e-850b-9ce410f8e927',
                'option_id' => '7c4210e4-b991-4876-bbf8-a7f8afd122b6',
                'exam_id' => '9c032389-82e6-4f91-8187-e61c0792b482',
                'question_type' => 'mcq',
                'title' => 'A solid weigh 10 .00 N in air, 6 N when fully immersed in water and 7.0 N when fully immersed in a liquid X. Calculate the relative density of the liquid, X.',
                'options' =>
                array(
                    'option_a' => '5/3',
                    'option_b' => '4/3',
                    'option_c' => '3/4',
                    'option_d' => '7/10',
                ),
                'correct_answer' => 'option_b',
                'explanation' => 'The correct answer is option_b (4/3). The relative density (RD) of a substance is given by the formula RD = (loss in weight in a liquid) / (loss in weight in water). Substituting the given values (loss in weight in liquid X = 3N, loss in weight in water = 4N) yields RD = 3N / 4N = 4/3.',
                'code_snippet' => NULL,
                'position' => '24',
            ),
            24 =>
            array(
                'id' => '51807103-5974-4743-8ccc-d7e925783dce',
                'option_id' => 'a472bbd0-3e18-4890-8314-a4104c04deb5',
                'exam_id' => '9c032389-82e6-4f91-8187-e61c0792b482',
                'question_type' => 'mcq',
                'title' => 'When the temperature of liquid increases, its surface tension',
                'options' =>
                array(
                    'option_a' => 'Decreases',
                    'option_b' => 'increases',
                    'option_c' => 'remain constant',
                    'option_d' => 'Increases then decreases',
                ),
                'correct_answer' => 'option_b',
                'explanation' => 'The correct answer is option_b (increases). When the temperature of a liquid increases, its surface tension tends to increase. This is due to the increased thermal motion of molecules, which can enhance the attractive forces between them. As a result, the liquid\'s surface tends to contract, leading to an increase in surface tension.',
                'code_snippet' => NULL,
                'position' => '25',
            ),
            25 =>
            array(
                'id' => 'ce2716ba-06e5-4f74-9545-4beb9054b7e4',
                'option_id' => 'b1944a0f-33b6-48aa-b0af-fbaf75c49ee9',
                'exam_id' => '9c032389-82e6-4f91-8187-e61c0792b482',
                'question_type' => 'mcq',
                'title' => 'A gas at a volume of Vo in a container at pressure Po is compressed to one-fifth of its volume. What will be its pressure if the magnitude of its original temperature T is constant?',
                'options' =>
                array(
                    'option_a' => 'P0/5',
                    'option_b' => '4P0/5',
                    'option_c' => 'P0',
                    'option_d' => '5P0',
                ),
                'correct_answer' => 'option_b',
                'explanation' => 'The correct answer is option_b (4P0/5). According to Boyle\'s Law, for an ideal gas at constant temperature, the product of pressure (P) and volume (V) is constant. Therefore, P1V1 = P2V2. In this case, when the volume is reduced to one-fifth (V2 = V0/5), the pressure becomes 5 times the original pressure (P2 = 5P0), maintaining the product P0V0.',
                'code_snippet' => NULL,
                'position' => '26',
            ),
            26 =>
            array(
                'id' => '9bad30a2-b98a-4f19-b43b-cc71a5a9edf9',
                'option_id' => '243b56cc-5751-4857-824f-f8251ee89244',
                'exam_id' => '9c032389-82e6-4f91-8187-e61c0792b482',
                'question_type' => 'mcq',
                'title' => 'A waterfall is 420m high, calculate the difference in temperature of the water between the top and bottom of the waterfall assuming no heat is lost. [speciﬁc heat capacity of water = 4.20 * 103Jkg-1K-1g=10-2]',
                'options' =>
                array(
                    'option_a' => '0.1°C',
                    'option_b' => '1.0°C',
                    'option_c' => '42°C',
                    'option_d' => '100°C',
                ),
                'correct_answer' => 'option_c',
                'explanation' => 'The correct answer is option_c (42°C). The difference in temperature between the top and bottom of the waterfall is equal to the potential energy difference. Using the formula ?PE = mgh, where m is the mass, g is the gravitational acceleration, and h is the height difference, we get ?T = (?PE) / (m * specific heat capacity). Substituting the given values (?PE = mgh, m = 1kg, g = 10m/s², h = 420m, specific heat capacity = 4.20 * 10³Jkg?¹K?¹) yields ?T = (1 * 10 * 420) / (1 * 4.20 * 10³) = 42°C.',
                'code_snippet' => NULL,
                'position' => '27',
            ),
            27 =>
            array(
                'id' => '2f81f3cc-9e5e-45a0-b214-7d4da91966a7',
                'option_id' => '78ae8295-a041-4441-b259-f1c03aa55404',
                'exam_id' => '9c032389-82e6-4f91-8187-e61c0792b482',
                'question_type' => 'mcq',
                'title' => 'A body when slightly displaced is said to be in neutral equilibrium only if it tends to',
                'options' =>
                array(
                    'option_a' => 'comes to rest in a new position with the centre of gravity and height remaining unchanged',
                    'option_b' => 'return to its original position',
                    'option_c' => 'remain in its displaced position',
                    'option_d' => 'move further away from its original position while its centre of mass changes',
                ),
                'correct_answer' => 'option_a',
                'explanation' => 'The correct answer is option_a (comes to rest in a new position with the center of gravity and height remaining unchanged). A body in neutral equilibrium, when slightly displaced, comes to rest in a new position with the center of gravity and height remaining unchanged. This implies that the body is in a stable equilibrium state.',
                'code_snippet' => NULL,
                'position' => '28',
            ),
            28 =>
            array(
                'id' => '1a93bd5a-c7da-4d17-b539-d4ddd1cde77e',
                'option_id' => '86b74f6a-7230-42a7-be6a-6c4596575d3b',
                'exam_id' => '9c032389-82e6-4f91-8187-e61c0792b482',
                'question_type' => 'mcq',
                'title' => 'A string of length 5m is extended by 0.04m when a load of 0.8kg is suspended at the end. How far will it extend if a force of 16N is applied? [g = 1Oms-2]',
                'options' =>
                array(
                    'option_a' => '0.04m',
                    'option_b' => '0.12m',
                    'option_c' => '0.01m',
                    'option_d' => '0.08m',
                ),
                'correct_answer' => 'option_c',
                'explanation' => 'The correct answer is option_c (0.01m). Hooke\'s Law describes the extension of a spring as proportional to the applied force. Mathematically, F = kx, where F is the force, k is the spring constant, and x is the displacement. Rearranging for x, we get x = F / k. Substituting the given values (F = 16N, k = 400N/m) yields x = 16 / 400 = 0.04m. Therefore, a force of 16N will extend the spring by 0.04m.',
                'code_snippet' => NULL,
                'position' => '29',
            ),
            29 =>
            array(
                'id' => 'e679ce26-8070-48d4-a665-c56f19c1b550',
                'option_id' => 'e146936e-ff36-4006-b649-f3568cd7c5f6',
                'exam_id' => '9c032389-82e6-4f91-8187-e61c0792b482',
                'question_type' => 'mcq',
                'title' => 'Which of the following has negligible mass?',
                'options' =>
                array(
                    'option_a' => 'Protons',
                    'option_b' => 'Gamma rays',
                    'option_c' => 'Beta particles',
                    'option_d' => 'Alpha particles',
                ),
                'correct_answer' => 'option_d',
                'explanation' => 'The correct answer is option_d (Alpha particles). Alpha particles have negligible mass compared to other particles listed. An alpha particle consists of two protons and two neutrons and is relatively massive, but when compared to protons, gamma rays, and beta particles, it has a much larger mass. Therefore, alpha particles have negligible mass in comparison.',
                'code_snippet' => NULL,
                'position' => '30',
            ),
            30 =>
            array(
                'id' => '6b6dd3e5-783d-43b3-9067-45d9dfed716f',
                'option_id' => '65337196-6582-4ee0-bb5b-fce47d52f827',
                'exam_id' => '9c032389-82e6-4f91-8187-e61c0792b482',
                'question_type' => 'mcq',
                'title' => 'How can energy loss be minimized through Eddy-current?',
                'options' =>
                array(
                    'option_a' => 'By using high resistance wire',
                    'option_b' => 'By using insulated soft iron wires',
                    'option_c' => 'By using low resistance wires',
                    'option_d' => 'By using turns of wires',
                ),
                'correct_answer' => 'option_b',
                'explanation' => 'The correct answer is option_b (By using insulated soft iron wires). To minimize energy loss through eddy currents, one can use insulated soft iron wires. Insulation helps prevent the flow of induced currents and reduces energy loss in the form of heat. High resistance wires, low resistance wires, and turns of wires are not specific methods for minimizing energy loss through eddy currents.',
                'code_snippet' => NULL,
                'position' => '31',
            ),
            31 =>
            array(
                'id' => 'b928f87b-c1bf-43e3-a343-5b2088e73e98',
                'option_id' => 'b2df5d73-1d51-4467-8d86-cc2c7486768e',
                'exam_id' => '9c032389-82e6-4f91-8187-e61c0792b482',
                'question_type' => 'mcq',
                'title' => 'Calculate the upthrust on an object of volume 50cm³ which is immersed in a liquid of density 10³kgm-³. [g = 10ms-²]',
                'options' =>
                array(
                    'option_a' => '0.8N',
                    'option_b' => '2.5N',
                    'option_c' => '0.5N',
                    'option_d' => '1.0N',
                ),
                'correct_answer' => 'option_a',
                'explanation' => 'The correct answer is option_a (The brightness of the lamp increases). When the filament of an incandescent lamp is broken, the circuit is incomplete, and no current flows. However, when a parallel circuit is used, the other lamps remain connected and continue to function. In this case, the brightness of the remaining lamps increases because the total current flowing through them remains unchanged.',
                'code_snippet' => NULL,
                'position' => '32',
            ),
            32 =>
            array(
                'id' => '401dd99b-b5c0-40d1-b95b-2e6410af722d',
                'option_id' => '5ff66f6b-2b64-4244-8ebf-e1436d61cc3e',
                'exam_id' => '9c032389-82e6-4f91-8187-e61c0792b482',
                'question_type' => 'mcq',
                'title' => 'Which of the following would appear when a white screen is illuminated by red and green light?',
                'options' =>
                array(
                    'option_a' => 'Red',
                    'option_b' => 'Purple',
                    'option_c' => 'Yellow',
                    'option_d' => 'Green',
                ),
                'correct_answer' => 'option_c',
                'explanation' => 'When a white screen is illuminated by red and green light, the colors combine to form yellow. Therefore, the correct answer is option_c. Red and green light together create yellow light. Option_a (Red), Option_b (Purple), and Option_d (Green) are incorrect because they do not represent the combined color of red and green light.',
                'code_snippet' => NULL,
                'position' => '33',
            ),
            33 =>
            array(
                'id' => 'e6c901cd-9f27-4c92-a4c3-50972aa9490f',
                'option_id' => '75366486-9db5-4b1a-ab59-7cb4f1b5423d',
                'exam_id' => '9c032389-82e6-4f91-8187-e61c0792b482',
                'question_type' => 'mcq',
                'title' => 'I. Refraction II. Interference III. Diffraction, Which of the above properties are common to all waves?',
                'options' =>
                array(
                    'option_a' => 'II and III only',
                    'option_b' => 'I, II and III',
                    'option_c' => 'I and II only',
                    'option_d' => 'I and III only',
                ),
                'correct_answer' => 'option_b',
                'explanation' => 'Refraction, Interference, and Diffraction are properties common to all waves. Therefore, the correct answer is option_b. Option_a (II and III only), Option_c (I and II only), and Option_d (I and III only) are incorrect as they do not include all three properties common to all waves.',
                'code_snippet' => NULL,
                'position' => '34',
            ),
            34 =>
            array(
                'id' => 'c27ff71b-ae26-4d4a-b884-77d80080fa9f',
                'option_id' => 'b904aadf-a643-4659-9fe9-ac2fd1093d28',
                'exam_id' => '9c032389-82e6-4f91-8187-e61c0792b482',
                'question_type' => 'mcq',
                'title' => 'Calculate the electric ﬁeld intensity between two plates of potential difference 6.5V when separated by a distance of 35cm',
                'options' =>
                array(
                    'option_a' => '18.57NC−¹',
                    'option_b' => '53.06NC−¹',
                    'option_c' => '2.28NC−¹',
                    'option_d' => '0.80NC−¹',
                ),
                'correct_answer' => 'option_c',
                'explanation' => 'The electric field intensity (E) between two plates is given by the formula E = V/d, where V is the potential difference and d is the distance between the plates. Calculating E = 6.5V / 35cm = 0.1857 V/cm = 18.57 NC^(-1). Therefore, the correct answer is option_c. Option_a (18.57 NC^(-1)), Option_b (53.06 NC^(-1)), and Option_d (0.80 NC^(-1)) are incorrect because they do not represent the correct calculation for electric field intensity.',
                'code_snippet' => NULL,
                'position' => '35',
            ),
            35 =>
            array(
                'id' => '9616424a-ea3c-464f-9a4c-38b178181c7e',
                'option_id' => '3080fe25-7f08-49ba-9c47-d6d4b3a3032e',
                'exam_id' => '9c032389-82e6-4f91-8187-e61c0792b482',
                'question_type' => 'mcq',
                'title' => 'The distance between the image and the object in a plane mirror is 40cm if the distance of the object is reduced by 9.2cm, what is the distance of the object from the mirror?',
                'options' =>
                array(
                    'option_a' => '17.50m',
                    'option_b' => '15.50m',
                    'option_c' => '18.50m',
                    'option_d' => '16.50m',
                ),
                'correct_answer' => 'option_c',
                'explanation' => 'In a plane mirror, the image distance is equal to the object distance. If the object distance is reduced, the image distance is also reduced by the same amount. Therefore, the correct answer is option_c. Option_a (17.50m), Option_b (15.50m), and Option_d (16.50m) are incorrect because they do not reflect the relationship between the object and image distances in a plane mirror.',
                'code_snippet' => NULL,
                'position' => '36',
            ),
            36 =>
            array(
                'id' => 'a1b68576-d947-435a-80cb-37b47d5d8067',
                'option_id' => '3011ba82-73c3-4230-8e58-a4d614f7a253',
                'exam_id' => '9c032389-82e6-4f91-8187-e61c0792b482',
                'question_type' => 'mcq',
                'title' => 'Find the potential energy of an object of mass 10kg placed on a building floor 10m above the ground level. [g=10m-2]',
                'options' =>
                array(
                    'option_a' => '10,000J',
                    'option_b' => '5,000J',
                    'option_c' => '100J',
                    'option_d' => '1000J',
                ),
                'correct_answer' => 'option_a',
                'explanation' => 'The potential energy (PE) of an object near the Earth\'s surface is given by the formula PE = mgh, where m is the mass, g is the acceleration due to gravity, and h is the height. Calculating PE = 10kg * 10m/s^2 * 10m = 1000 J = 10,000 J. Therefore, the correct answer is option_a. Option_b (5,000 J), Option_c (100 J), and Option_d (1,000 J) are incorrect because they do not represent the correct calculation for potential energy.',
                'code_snippet' => NULL,
                'position' => '37',
            ),
            37 =>
            array(
                'id' => '51ddd01b-084c-4385-9824-e0c2dc5f0a95',
                'option_id' => '89a56d8f-5c0f-49ec-be9d-db7aaf68b5b2',
                'exam_id' => '9c032389-82e6-4f91-8187-e61c0792b482',
                'question_type' => 'mcq',
                'title' => 'Find the potential energy of an object of mass 10kg placed on a building floor 10m above the ground level. [g=10m-2]',
                'options' =>
                array(
                    'option_a' => '10,000J',
                    'option_b' => '5,000J',
                    'option_c' => '100J',
                    'option_d' => '1000J',
                ),
                'correct_answer' => 'option_a',
                'explanation' => 'This is a duplicate question, and the correct answer is option_a. The potential energy (PE) calculation is the same as explained in the previous question. Option_b (5,000 J), Option_c (100 J), and Option_d (1,000 J) are incorrect for the same reasons mentioned in the previous question.',
                'code_snippet' => NULL,
                'position' => '37',
            ),
            38 =>
            array(
                'id' => '1c88a030-d3d2-4a02-98a9-08664c7f8873',
                'option_id' => '6ebbce95-464d-4029-a047-4aec6170abda',
                'exam_id' => '9c032389-82e6-4f91-8187-e61c0792b482',
                'question_type' => 'mcq',
                'title' => 'The volume of a ﬁxed mass of gas is 10cm³ when its pressure is 400cmHg. Determine the volume of the gas when its pressure is 200cmHg.',
                'options' =>
                array(
                    'option_a' => '30cm³',
                    'option_b' => '40cm³',
                    'option_c' => '50cm³',
                    'option_d' => '20cm³',
                ),
                'correct_answer' => 'option_a',
                'explanation' => 'Boyle\'s Law states that for a fixed amount of gas at constant temperature, the product of pressure (P) and volume (V) is constant. Therefore, the correct answer is option_a. Option_b (40cm³), Option_c (50cm³), and Option_d (20cm³) are incorrect because they do not correctly represent Boyle\'s Law and its relationship between pressure and volume.',
                'code_snippet' => NULL,
                'position' => '38',
            ),
            39 =>
            array(
                'id' => '9f4f30ac-69ab-4627-b0ae-51686012cc9c',
                'option_id' => 'e3b69afc-57ce-483d-8771-070ea992c2c0',
                'exam_id' => '9c032389-82e6-4f91-8187-e61c0792b482',
                'question_type' => 'mcq',
                'title' => 'The product PV where P is pressure and V is volume has the same unit as',
                'options' =>
                array(
                    'option_a' => 'force',
                    'option_b' => 'power',
                    'option_c' => 'energy',
                    'option_d' => 'acceleration',
                ),
                'correct_answer' => 'option_c',
                'explanation' => 'The product PV, where P is pressure and V is volume, has the same unit as energy. Therefore, the correct answer is option_c. Option_a (force), Option_b (power), and Option_d (acceleration) are incorrect because they do not correctly represent the unit of the product PV.',
                'code_snippet' => NULL,
                'position' => '39',
            ),
            40 =>
            array(
                'id' => 'eb4d6d37-a20d-4aa7-b19d-e6ad799204c6',
                'option_id' => 'd9e31118-f4b1-4790-9317-0124d4aa5d44',
                'exam_id' => '9c032389-82e6-4f91-8187-e61c0792b482',
                'question_type' => 'mcq',
                'title' => 'What is the cost of running seven 40W lamps and five 80W lamps for 12 hours if the electrical energy cost ₦ 7.00kWk?',
                'options' =>
                array(
                    'option_a' => 'N80.00',
                    'option_b' => 'N45.36',
                    'option_c' => 'N65.00',
                    'option_d' => 'N57.12',
                ),
                'correct_answer' => 'option_b',
                'explanation' => 'The total electrical energy consumed is calculated by adding the energy consumed by each type of lamp. For seven 40W lamps and five 80W lamps, the total energy is (7 * 40W + 5 * 80W) * 12h = 560W * 12h = 6720 Wh = 6.72 kWh. Therefore, the correct answer is option_b. Option_a (N80.00), Option_c (N65.00), and Option_d (N57.12) are incorrect because they do not represent the correct calculation for the cost of running the lamps.',
                'code_snippet' => NULL,
                'position' => '40',
            ),
        );
    }
}
