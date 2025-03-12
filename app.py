from flask import Flask, request, jsonify
import requests

app = Flask(__name__)

# Hugging Face API kulcs és modell beállítása
API_KEY = "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"
MODEL_NAME = "tiiuae/falcon-7b-instruct"
API_URL = f"https://api-inference.huggingface.co/models/{MODEL_NAME}"

# Edzésterv generálásának funkciója
def generate_workout_plan(user_data):
    prompt = f"""
    Create a **5 day hypertrophy workout plan** for the following person:
    - **Gender**: man
    - **Age**: 20 years
    - **Weight**: 90 kg
    - **Height**: 190 cm
    - **Goal**: gain muscle
    - **Body type**: endomorph
    - **Current body fat percentage**: 20 %
    - **Desired body fat percentage**: 10 %
    - **Workout duration per week**: 5 sessions
    - **Workout length**: 60 minutes
    - **Workout place**: GYM
    - **Focused muscle groups**: Chest, Back
    - **Sensitive body part**: none

    Please create a **detailed 6-day workout plan** with the following:
    - A warm-up (5-10 minutes)
    - 4-6 main exercises for each day (sets, reps, and rest times)
    - A cool-down/stretch (5-10 minutes)
    - Progressive overload recommendations

    Please follow this weekly workout structure:

    - **Monday**: Chest, Triceps, Shoulders
    - **Tuesday**: Back, Biceps, Abs
    - **Wednesday**: Legs, Hamstrings, Glutes
    - **Thursday**: Chest, Triceps, Shoulders
    - **Friday**: Back, Biceps, Abs
    - **Saturday**: Legs, Hamstrings, Glutes
    - **Sunday**: Rest

    For each day, provide:
    - Specific exercises for the focused muscle groups
    - Sets, repetitions, and rest time for each exercise
    - A cool-down/stretch routine to follow after the workout

    Please format it in a clear and well-organized way, broken down by days, with recommended progression for each workout!
    """



    headers = {"Authorization": f"Bearer {API_KEY}"}
    response = requests.post(API_URL, headers=headers, json={"inputs": prompt})

    if response.status_code == 200:
        return response.json()[0]['generated_text']
    else:
        return f"Error: {response.status_code} - {response.text}"

# API endpoint a munkamenethez
@app.route("/generate_workout", methods=["POST"])
def workout_api():
    # JSON adat lekérése
    data = request.json
    user_data = data.get("user_data")
    
    if not user_data:
        return jsonify({"error": "Missing user data"}), 400

    # Edzésterv generálása
    workout_plan = generate_workout_plan(user_data)
    
    # Válasz visszaküldése
    return jsonify({"workout_plan": workout_plan})

# Flask szerver indítása
if __name__ == "__main__":
    app.run(debug=True)
